<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\PostForm;
use Application\Service\Phrase;

/**
 * Class IndexController
 */
class IndexController extends AbstractActionController
{
    /**
     * Index action
     *
     * @return ViewModel
     */
    public function indexAction()
    {
        $statistics = [];
        $form = new PostForm();

        if ($this->getRequest()->isPost()) {
            $data = $this->params()->fromPost();

            $form->setData($data);

            if ($form->isValid()) {
                $data = $form->getData();

                $phrase = new Phrase();

                $statistics = $phrase->analyze($data['content'])->getStatistics();
            }
        }

        return new ViewModel([
            'form' => $form,
            'statistics' => $statistics,
        ]);
    }
}
