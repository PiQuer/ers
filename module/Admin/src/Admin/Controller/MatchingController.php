<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Admin\Form;
use Admin\InputFilter;
use ersBase\Entity;
use ersBase\Service;

class MatchingController extends AbstractActionController {
    public function indexAction() {
        $page = (int) $query = $this->params()->fromQuery('page', 1);
        $forrest = new Service\BreadcrumbService();
        $forrest->set('matching', 'admin/matching');
        
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $limit = 50;
        $offset = ($limit * ($page - 1));
        # findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
        $matchings = $em->getRepository("ersBase\Entity\Match")
                ->findBy(array('status' => 'active'), array('updated' => 'DESC'), $limit, $offset);
        
        $qb = $em->getRepository("ersBase\Entity\Match")->createQueryBuilder('m');
        $qb->select('count(m.id)');
        $count = $qb->getQuery()->getSingleScalarResult();
        $pagecount = floor($count/$limit);
        return new ViewModel(array(
            'matchings' => $matchings,
            'page' => $page,
            'pagecount' => $pagecount,
        ));
    }
    
    public function manualAction() {        
        $logger = $this->getServiceLocator()->get('Logger');
        
        #$logger->info($param_orders);
        #$logger->info($param_statements);
        
        $forrest = new Service\BreadcrumbService();
        $forrest->set('matching', 'admin/matching', array('action' => 'manual'));
        
        $form = new Form\ManualMatch();
        
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        /*
         * select order which are unpaid
         * TODO: order by prename of buyer because it's most likely the name 
         * from the bank statement.
         * TODO: Add filter to select status of orders. unpaid is the default 
         * status but underpaid would be nice, too.
         */
        $orders = $em->getRepository("ersBase\Entity\Order")
                ->findBy(array('payment_status' => 'unpaid'));
        
        #$repository = $em->getRepository("ersBase\Entity\Order");

        #$qb = $repository->createQueryBuilder('o');
        #$qb->leftJoin('o.matches', 'm');
        #$qb->where($qb->expr()->isNull('m.Order_id'));
        #$qb->andWhere("o.payment_status != 'cancelled'");
        #$qb->andWhere("o.payment_status != 'refund'");

        #$orders = $qb->getQuery()->getResult();
        
        $order_options = array();
        foreach($orders as $order) {
            $order_options[] = array(
                'label' => $order->getId(),
                'value' => $order->getId(),
            );
        }
        $form->get('orders')->setValueOptions($order_options);
        
        /*
         * add bankaccounts to view model
         */
        $bankaccounts = $em->getRepository("ersBase\Entity\BankAccount")
            ->findBy(array());
        
        /*
         * add bank statements to as value options to form
         */
        $statements = $em->getRepository("ersBase\Entity\BankStatement")
                ->findAll();
        $statement_options = array();
        foreach($statements as $statement) {
            $statement_options[] = array(
                'label' => $statement->getId(),
                'value' => $statement->getId(),
            );
        }
        $form->get('statements')->setValueOptions($statement_options);
        
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $inputFilter = new InputFilter\ManualMatch();
            $form->setInputFilter($inputFilter->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                
                $logger->info(var_export($data, true));
                
                /*
                 * get orders
                 */
                $orders = array();
                foreach($data['orders'] as $order_id) {
                    $orders[] = $em->getRepository("ersBase\Entity\Order")
                        ->findBy(array('id' => $order_id));
                }
                
                /*
                 * get statements
                 */
                $statements = array();
                foreach($data['statements'] as $statement_id) {
                    $statements[] = $em->getRepository("ersBase\Entity\BankStatement")
                        ->findBy(array('id' => $statement_id));
                }
                
                /*
                 * do matches and set order to paid
                 */
                /*foreach($orders as $order) {
                    if($order->getSum() <= (float) $statement->getAmount()) {
                        $order->setStatus('paid');
                    }
                    $match = new Entity\Match();
                    $match->setOrder($order);
                    $match->setBankStatement($statement);
                    $match->setAdminId($this->zfcUserAuthentication()->getIdentity()->getId());
                }*/
                
                $params['statements'] = $data['statements'];
                $params['orders'] = $data['orders'];
                
                return $this->redirect()->toRoute('admin/matching', 
                        array('action' => 'accept'),
                        array('query' => $params)
                    );
            } else {
                $logger->warn($form->getMessages());
            }
        }
        
        return new ViewModel(array(
            'orders' => $orders,
            'bankaccounts' => $bankaccounts,
            'form' => $form,
        ));
    }
    
    public function acceptAction() {
        $logger = $this->getServiceLocator()->get('Logger');
        
        $param_orders = $this->params()->fromQuery('orders', array());
        $param_statements = $this->params()->fromQuery('statements', array());
        
        $params['orders'] = $param_orders;
        $params['statements'] = $param_statements;
        
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $form = new Form\AcceptMatch();
        
        $orders = array();
        $order_options = array();
        foreach($param_orders as $order_id) {
            $orders[] = $em->getRepository("ersBase\Entity\Order")
                ->findOneBy(array('id' => $order_id));
            $order_options[] = array(
                'label' => $order_id,
                'value' => $order_id,
            );
        }
        $form->get('Order_id')->setValueOptions($order_options);
        
        
        $statements = array();
        $statement_options = array();
        foreach($param_statements as $statement_id) {
            $statements[] = $em->getRepository("ersBase\Entity\BankStatement")
                ->findOneBy(array('id' => $statement_id));
            $statement_options[] = array(
                'label' => $statement_id,
                'value' => $statement_id,
            );
        }
        $form->get('BankStatement_id')->setValueOptions($statement_options);
        
        $form->get('Admin_id')->setValue($this->zfcUserAuthentication()->getIdentity()->getId());
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $inputFilter = new InputFilter\AcceptMatch();
            $form->setInputFilter($inputFilter->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                
                $logger->info(var_export($data, true));
                
                $status = 'unpaid';
                if($data['half-match'] == null) {
                    $status = 'paid';
                }
                
                /*
                 * get orders
                 */
                $orders = array();
                foreach($data['Order_id'] as $order_id) {
                    $orders[] = $em->getRepository("ersBase\Entity\Order")
                        ->findOneBy(array('id' => $order_id));
                }
                
                $order_sum = 0;
                foreach($orders as $order) {
                    /*
                     * calculate prices with payment fees.
                     */
                    $order_sum += $order->getSum();
                }
                
                /*
                 * get statements
                 */
                $statements = array();
                foreach($data['BankStatement_id'] as $statement_id) {
                    $statements[] = $em->getRepository("ersBase\Entity\BankStatement")
                        ->findOneBy(array('id' => $statement_id));
                }
                
                $statement_sum = 0;
                foreach($statements as $statement) {
                    $statement_sum += (float) $statement->getAmount()->getValue();
                }
                
                /*
                 * do matches and set order to paid
                 */
                foreach($orders as $order) {
                    foreach($order->getItems() as $item) {
                        if($status == 'paid') {
                            $item->setStatus('paid');
                            $em->persist($item);
                        } elseif($status == 'unpaid') {
                            $item->setStatus('ordered');
                            $em->persist($item);
                        }
                    }
                    $order->setPaymentStatus($status);
                    $em->persist($order);
                    
                    foreach($statements as $statement) {
                        $match = new Entity\Match();
                        $match->setOrder($order);
                        $match->setStatus('active');
                        $match->setBankStatement($statement);
                        $user = $this->zfcUserAuthentication()->getIdentity();
                        #$match->setAdminId($this->zfcUserAuthentication()->getIdentity()->getId());
                        $match->setAdmin($user);
                        $match->setComment($data['comment']);
                        
                        $em->persist($match);
                        
                        $statement->setStatus('matched');
                        $em->persist($statement);
                    }
                }
                $em->flush();
                
                #$params['statements'] = $data['statements'];
                #$params['orders'] = $data['orders'];
                
                return $this->redirect()->toRoute('admin/matching', array('action' => 'manual'));
            } else {
                $logger->warn($form->getMessages());
            }
        }
        
        return new ViewModel(array(
            'orders' => $orders,
            'statements' => $statements,
            'form' => $form,
            'params' => $params,
        ));
    }
    
    public function unlinkAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/matching', array());
        }
        
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('matching')) {
            $forrest->set('matching', 'admin/matching', array('action' => 'manual'));
        }
        
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $match = $em->getRepository("ersBase\Entity\Match")
                ->findOneBy(array('id' => $id));
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $ret = $request->getPost('del', 'No');

            if ($ret == 'Yes') {
                $id = (int) $request->getPost('id');
                
                $match = $em->getRepository("ersBase\Entity\Match")
                    ->findOneBy(array('id' => $id));
                
                $match->setStatus('disabled');
                $em->persist($match);
                
                $bs = $match->getBankStatement();
                $bs->setStatus('new');
                $em->persist($bs);
                
                $order = $match->getOrder();
                $order->setPaymentStatus('unpaid');
                $em->persist($order);
                
                foreach($order->getItems() as $item) {
                    $item->setStatus('ordered');
                    $em->persist($item);
                }
                #$em->remove($match);
                $em->flush();
                
                $breadcrumb = $forrest->get('matching');
                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            }
        }
        
        return new ViewModel(array(
            'match' => $match,
        ));
    }
    
    public function disabledAction() {
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $forrest = new Service\BreadcrumbService();
        $forrest->set('matching', 'admin/matching', array('action' => 'disable'));
        
        $statements = $em->getRepository("ersBase\Entity\BankStatement")
                ->findBy(array('status' => 'disabled'), array('updated' => 'DESC'));
        
        return new ViewModel(array(
            'statements' => $statements
        ));
    }
    
    public function disableAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/matching', array('action' => 'disabled'));
        }
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $statement = $em->getRepository("ersBase\Entity\BankStatement")
                ->findOneBy(array('id' => $id));
        
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('matching')) {
            $forrest->set('matching', 'admin/matching', array('action' => 'manual'));
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $ret = $request->getPost('del', 'No');

            if ($ret == 'Yes') {
                $id = (int) $request->getPost('id');
                
                $statement = $em->getRepository("ersBase\Entity\BankStatement")
                    ->findOneBy(array('id' => $id));
                
                $statement->setStatus('disabled');
                $em->persist($statement);
                $em->flush();
                
                $breadcrumb = $forrest->get('matching');
                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            }
        }
        
        return new ViewModel(array(
            'statement' => $statement,
            'breadcrumb' => $forrest->get('matching'),
        ));
    }
    
    public function enableAction() {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('admin/matching', array('action' => 'disabled'));
        }
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $statement = $em->getRepository("ersBase\Entity\BankStatement")
                ->findOneBy(array('id' => $id));
        
        $forrest = new Service\BreadcrumbService();
        if(!$forrest->exists('matching')) {
            $forrest->set('matching', 'admin/matching', array('action' => 'disabled'));
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $ret = $request->getPost('del', 'No');

            if ($ret == 'Yes') {
                $id = (int) $request->getPost('id');
                
                $statement = $em->getRepository("ersBase\Entity\BankStatement")
                    ->findOneBy(array('id' => $id));
                
                $statement->setStatus('new');
                $em->persist($statement);
                $em->flush();
                
                $breadcrumb = $forrest->get('matching');
                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            }
        }
        
        return new ViewModel(array(
            'statement' => $statement,
            'breadcrumb' => $forrest->get('matching'),
        ));
    }
}
