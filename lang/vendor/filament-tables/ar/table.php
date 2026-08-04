<?php

return [

    'column_toggle' => [

        'heading' => 'الأعمدة',

    ],

    'columns' => [

        'actions' => [
            'label' => 'إجراء|إجراءات',
        ],

        'text' => [

            'actions' => [
                'collapse_list' => 'إظهار :count أقل',
                'expand_list' => 'إظهار :count إضافي',
            ],

            'more_list_items' => 'و :count أخرى',

        ],

    ],

    'fields' => [

        'bulk_select_page' => [
            'label' => 'تحديد/إلغاء تحديد كافة العناصر للإجراءات الجماعية.',
        ],

        'bulk_select_record' => [
            'label' => 'تحديد/إلغاء تحديد العنصر :key للإجراءات الجماعية.',
        ],

        'bulk_select_group' => [
            'label' => 'تحديد/إلغاء تحديد المجموعة :title للإجراءات الجماعية.',
        ],

        'search' => [
            'label' => 'بحث',
            'placeholder' => 'بحث',
            'indicator' => 'بحث',
        ],

    ],

    'summary' => [

        'heading' => 'الملخص',

        'subheadings' => [
            'all' => 'كل :label',
            'group' => 'ملخص :group',
            'page' => 'هذه الصفحة',
        ],

        'summarizers' => [

            'average' => [
                'label' => 'المتوسط',
            ],

            'count' => [
                'label' => 'العدد',
            ],

            'sum' => [
                'label' => 'المجموع',
            ],

        ],

    ],

    'actions' => [

        'disable_reordering' => [
            'label' => 'إنهاء إعادة الترتيب',
        ],

        'enable_reordering' => [
            'label' => 'إعادة ترتيب السجلات',
        ],

        'filter' => [
            'label' => 'تصفية',
        ],

        'group' => [
            'label' => 'تجميع',
        ],

        'open_bulk_actions' => [
            'label' => 'إجراءات جماعية',
        ],

        'toggle_columns' => [
            'label' => 'إظهار/إخفاء الأعمدة',
        ],

    ],

    'empty' => [

        'heading' => 'لا يوجد :model',

        'description' => 'أنشئ :model للبدء.',

    ],

    'filters' => [

        'actions' => [

            'apply' => [
                'label' => 'تطبيق التصفية',
            ],

            'remove' => [
                'label' => 'إزالة التصفية',
            ],

            'remove_all' => [
                'label' => 'إزالة كل التصفيات',
                'tooltip' => 'إزالة كل التصفيات',
            ],

            'reset' => [
                'label' => 'إعادة تعيين',
            ],

        ],

        'heading' => 'التصفية',

        'indicator' => 'تصفيات نشطة',

        'multi_select' => [
            'placeholder' => 'الكل',
        ],

        'select' => [
            'placeholder' => 'الكل',
        ],

        'trashed' => [

            'label' => 'السجلات المحذوفة',

            'only_trashed' => 'المحذوفة فقط',

            'with_trashed' => 'مع المحذوفة',

            'without_trashed' => 'بدون المحذوفة',

        ],

    ],

    'grouping' => [

        'fields' => [

            'group' => [
                'label' => 'تجميع حسب',
                'placeholder' => 'تجميع حسب',
            ],

            'direction' => [

                'label' => 'اتجاه التجميع',

                'options' => [
                    'asc' => 'تصاعدي',
                    'desc' => 'تنازلي',
                ],

            ],

        ],

    ],

    'reorder_indicator' => 'اسحب وأفلت السجلات لإعادة الترتيب.',

    'selection_indicator' => [

        'selected_count' => 'سجل واحد محدد|:count سجلات محددة',

        'actions' => [

            'select_all' => [
                'label' => 'تحديد الكل (:count)',
            ],

            'deselect_all' => [
                'label' => 'إلغاء تحديد الكل',
            ],

        ],

    ],

    'sorting' => [

        'fields' => [

            'column' => [
                'label' => 'ترتيب حسب',
            ],

            'direction' => [

                'label' => 'اتجاه الترتيب',

                'options' => [
                    'asc' => 'تصاعدي',
                    'desc' => 'تنازلي',
                ],

            ],

        ],

    ],

];
