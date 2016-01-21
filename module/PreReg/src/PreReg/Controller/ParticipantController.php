<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace PreReg\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use PreReg\Form;
use ErsBase\Entity;
use ErsBase\Service;
use PreReg\InputFilter;

class ParticipantController extends AbstractActionController {
    /*
     * - Show list of participants of this session
     * - inclufde participant for which this user already bought products, if 
     *   the user is logged in.
     */
    public function indexAction()
    {
        $breadcrumbService = new Service\BreadcrumbService(); 
        $breadcrumbService->reset();
        $breadcrumbService->set('participant', 'participant');
     
        #$cartContainer = new Container('cart');
        $orderService = $this->getServiceLocator()
                ->get('ErsBase\Service\OrderService');
        $order = $orderService->getOrder();
        
        /*$em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');*/
        
        /*$order = $em->getRepository("ErsBase\Entity\Order")
                ->findOneBy(array('id' => $cartContainer->order_id));*/
        
        #$participants = $cartContainer->order->getParticipants();
        $participants = $order->getParticipants();
        
        foreach($participants as $participant) {
            if($participant->getCountryId()) {
                $country = $em->getRepository("ErsBase\Entity\Country")
                        ->findOneBy(array('id' => $participant->getCountryId()));
                $participant->setCountry($country);
            }
        }
        
        return new ViewModel(array(
            'participants' => $participants,
        ));
    }
    
    /*
     * add a participant user object to the session for which the buyer is 
     * able to assign a product afterwards.
     */
    public function addAction() {
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $form = new Form\Participant(); 
        #$form->setEntityManager($em);
        $form->setServiceLocation($this->getServiceLocator());
        $optionService = $this->getServiceLocator()
                ->get('ErsBase\Service\OptionService');
        #$form->get('Country_id')->setValueOptions($this->getCountryOptions());
        $form->get('Country_id')->setValueOptions($optionService->getCountryOptions());
        
        $user = new Entity\User();
        $user->setActive(false);
        $form->bind($user);
        
        $breadcrumbService = new Service\BreadcrumbService();
        
        $request = $this->getRequest(); 
        if($request->isPost()) 
        { 
            #$inputFilter = new InputFilter\Participant();
            #$inputFilter->setEntityManager($em);

            #$form->setInputFilter($inputFilter->getInputFilter()); 
            $form->setData($request->getPost()); 
            
            if($form->isValid())
            { 
                $orderService = $this->getServiceLocator()
                    ->get('ErsBase\Service\OrderService');
                $order = $orderService->getOrder();
                
                $participant = $em->getRepository('ErsBase\Entity\User')
                        ->findOneBy(array('email' => $user->getEmail(), 'active' => false));
                
                if($participant) {
                    $participant->loadData($user);
                    $em->persist($participant);
                    $orderService->addParticipant($participant);
                    #$em->persist($participant);
                } else {
                    $active_user = $em->getRepository('ErsBase\Entity\User')
                        ->findOneBy(array('email' => $user->getEmail(), 'active' => true));
                    
                    if($active_user) {
                        # TODO: flash error message: login is needed
                    } else {
                        #$em->persist($user);
                        $orderService->addParticipant($user);
                    }   
                }
                
                foreach($order->getPackages() as $package) {
                    error_log('package status: '.$package->getStatus().' ('.$package->getParticipant().')');
                }
                
                $orderService->setCountryId($user->getCountryId());
                
                if($user->getCountryId() == 0) {
                    $user->setCountryId(null);
                    $user->setCountry(null);
                }
                
                $em->persist($order);
                $em->flush();
                
                $breadcrumb = $breadcrumbService->get('participant');
                if($breadcrumb->route == 'product' && isset($breadcrumb->params['action']) && ($breadcrumb->params['action'] == 'add' || $breadcrumb->params['action'] == 'edit')) {
                    unset($breadcrumb->params['agegroup_id']);
                    $breadcrumb->options['fragment'] = 'person';
                    $breadcrumb->options['query']['participant_id'] = $user->getSessionId();
                }

                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            } else {
                $logger = $this->getServiceLocator()->get('Logger');
                $logger->warn($form->getMessages());
            } 
        }
        
        if(!$breadcrumbService->exists('participant')) {
            $breadcrumbService->set('participant', 'participant');
        }

        return new ViewModel(array(
            'form' => $form,
            'breadcrumb' => $breadcrumbService->get('participant'),
        ));
    }
    
    /*
     * edit a participant which is already added to this session or for which 
     * this user already bought a product. This user is only able to edit the 
     * details if the participant himself hasn't logged in to his account, yet.
     */
    public function editAction() 
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('participant', array(
                'action' => 'add'
            ));
        }
        
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $orderService = $this->getServiceLocator()
                ->get('ErsBase\Service\OrderService');
        $order = $orderService->getOrder();
        
        $participant = $order->getParticipantById($id);
        
        if(!$participant) {
            # TODO: add flash messenger message with error and return
        }
        /*$participant = $em->getRepository('ErsBase\Entity\User')
                ->findOneBy(array('id' => $id));*/
        
        #$cartContainer = new Container('cart');
        #$participant = $cartContainer->order->getParticipantBySessionId($id);
        
        $breadcrumbService = new Service\BreadcrumbService();
        
        $form = new Form\Participant(); 
        #$form->setEntityManager($em);
        $form->setServiceLocation($this->getServiceLocator());
        #$form->get('Country_id')->setValueOptions($this->getCountryOptions());
        $optionService = $this->getServiceLocator()
                ->get('ErsBase\Service\OptionService');
        $form->get('Country_id')->setValueOptions($optionService->getCountryOptions());
        $form->bind($participant);
        
        $request = $this->getRequest(); 
        if($request->isPost()) 
        {
            #$inputFilter = new InputFilter\Participant();
            #$form->setInputFilter($inputFilter->getInputFilter()); 
            $form->setData($request->getPost()); 
                
            if($form->isValid())
            { 
                #$participant = $form->getData();
                #$cartContainer = new Container('cart');
                #$cartContainer->order->setParticipantBySessionId($participant, $id);
                
                if($participant->getCountryId() == 0) {
                    $participant->setCountryId(null);
                    $participant->setCountry(null);
                }
                
                $em->persist($participant);
                $em->flush();
                
                $breadcrumb = $breadcrumbService->get('participant');
                return $this->redirect()->toRoute($breadcrumb->route, $breadcrumb->params, $breadcrumb->options);
            } else {
                $logger = $this->getServiceLocator()->get('Logger');
                $logger->warn($form->getMessages());
            } 
        }
        
        if(!$breadcrumbService->exists('participant')) {
            $breadcrumbService->set('participant', 'participant');
        }
        $breadcrumb = $breadcrumbService->get('participant');
        return new ViewModel(array(
            'id' => $id,
            'form' => $form,
            'breadcrumb' => $breadcrumb,
        ));
    }
    
    public function deleteAction() {
        # maybe we do not need to delete a participant here, because the 
        # participants user object is only held in the session and will be 
        # deleted after session is not valid anymore.
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('participant');
        }
        
        $breadcrumbService = new Service\BreadcrumbService();
        if(!$breadcrumbService->exists('participant')) {
            $breadcrumbService->set('participant', 'participant');
        }
        
        $breadcrumb = $breadcrumbService->get('participant');
        
        $em = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        
        $participant = $em->getRepository('ErsBase\Entity\User')
                ->findOneBy(array('id' => $id));
        
        $orderService = $this->getServiceLocator()
                ->get('ErsBase\Service\OrderService');
        $order = $orderService->getOrder();
        #$cartContainer = new Container('cart');
        #$participant = $cartContainer->order->getParticipantBySessionId($id);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
        
                $participant = $em->getRepository('ErsBase\Entity\User')
                    ->findOneBy(array('id' => $id));
                $package = $em->getRepository('ErsBase\Entity\Package')
                    ->findOneBy(array(
                        'participant_id' => $id, 
                        'order_id' => $order->getId(),
                        ));
                
                $em->remove($package);
                if(!$participant->getActive()) {
                    $em->remove($participant);
                }
                $em->flush();
                
                #$cartContainer->order->removeParticipantBySessionId($id);
            }

            return $this->redirect()->toRoute(
                    $breadcrumb->route, 
                    $breadcrumb->params, 
                    $breadcrumb->options
                );
        }

        $package = $order->getPackageByParticipantId($id);
        #$package = $cartContainer->order->getPackageByParticipantSessionId($id);
        
        
        return new ViewModel(array(
            'id'    => $id,
            'participant' => $participant,
            'package' => $package,
            'breadcrumb' => $breadcrumb,
        ));
    }
}