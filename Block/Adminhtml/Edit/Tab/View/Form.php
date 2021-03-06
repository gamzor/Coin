<?php

namespace Kirill\Coins\Block\Adminhtml\Edit\Tab\View;

use Magento\Backend\Block\Widget\Form\Generic;
use Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Customer\Model\CustomerFactory;
use Kirill\Coins\Model\CoinsRepository;
class Form extends Generic
{
    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $_customerFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry  $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory ,
     * @param \Kirill\Coins\Model\CoinsRepository $coinsRepository
     * @param array $data
     */
    public function __construct(
        Context                   $context,
        Registry                               $registry,
        FormFactory                       $formFactory,
        CustomerFactory                   $customerFactory,
        CoinsRepository $coinsRepository,
        array                                                     $data = []
    )
    {
        $this->_customerFactory = $customerFactory;
        $this->coinsRepository = $coinsRepository;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**Prepare form fields
     * @return Form
     * @throws \Magento\Framework\Exception\LocalizedException
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function _prepareForm(): Form
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $prefix = '_coins';
        $form->setHtmlIdPrefix($prefix);
        $form->setFieldNameSuffix('coins');


        /** @var $fieldset \Magento\Framework\Data\Form\Element\Fieldset */
        $fieldset = $form->addFieldset('coins_fieldset', ['legend' => __('Update Balance')]);

        $fieldset->addField(
            'amount_coins',
            'text',
            [
                'name' => 'amount_coins',
                'label' => __('Update Balance'),
                'title' => __('Update Balance'),
                'comment' => __('An amount on which to change the balance'),
                'data-form-part' => $this->getData('target_form'),
            ]
        );
        $fieldset->addField(
            'comment',
            'text',
            [
                'name' => 'comment',
                'label' => __('Comment'),
                'title' => __('Comment'),
                'comment' => __('Comment'),
                'data-form-part' => $this->getData('target_form')
            ]
        );
        $fieldset->addField(
            'total',
            'button',
            [
                'name' => 'total',
                'label' => __('Total'),
                'title' => __('Total'),
                'data-form-part' => $this->getData('target_form'),
                'value' => $this->coinsRepository->getTotalAmount($this->_coreRegistry->registry('current_customer_id'))
            ]
        );
        $this->setForm($form);
        return $this;
    }
}
