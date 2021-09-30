<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Kirill\Coins\Block\Adminhtml\Edit\Tab\View;

use Kirill\Coins\Model\Coins;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Customer\Model\Customer;
use Kirill\Coins\Model\ResourceModel\Coins\CollectionFactory;

class Form extends Generic
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @var \Kirill\Coins\Model\CoinsFactory
     */
    protected $coinsFactory;

    /**
     * @var \Magento\Customer\Model\CustomerFactory
     */
    protected $_customerFactory;
    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Customer\Model\CustomerFactory $customerFactory,
     * @param \Kirill\Coins\Model\CoinsFactory $coinsFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Kirill\Coins\Model\CoinsFactory $coinsFactory,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        \Magento\Store\Model\System\Store $systemStore,
        \Kirill\Coins\Block\Coins\History $collectionFactory,
        array $data = []
    ) {
        $this->_coinsFactory = $coinsFactory;
        $this->_systemStore = $systemStore;
        $this->_customerFactory = $customerFactory;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form fields
     *
     * @return Form
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function _prepareForm(): Form
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
        $prefix = '_coins';
        $form->setHtmlIdPrefix($prefix);
        $form->setFieldNameSuffix('coins');

        /** @var Customer $customer */
        $customer = $this->_customerFactory->create()->load($this->getRequest()->getParam('id'));

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
                'value' => $customer->getData('Сoins')
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
        $this->setForm($form);
        return $this;
    }
}
