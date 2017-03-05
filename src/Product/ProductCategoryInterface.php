<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\Product;

interface ProductCategoryInterface
{
    const CATEGORY_DIGITAL_GOODS = 'digital_goods';
    const CATEGORY_CLOTHING = 'clothing';
    const CATEGORY_PRESCRIPTION_DRUGS = 'prescription_drugs';
    const CATEGORY_NON_PRESCRIPTION_DRUGS = 'non_prescription_drugs';
    const CATEGORY_FOOD_GROCERIES = 'food_groceries';
    const CATEGORY_SOFTWARE_SERVICES = 'software_services';
    const CATEGORY_MAGAZINES = 'magazines';
    const CATEGORY_MAGAZINE_SUBSCRIPTIONS = 'magazine_subscriptions';
    const CATEGORY_BOOKS = 'books';
    const CATEGORY_TEXTBOOKS = 'textbooks';
    const CATEGORY_RELIGIOUS_BOOKS = 'religious_books';
    const CATEGORY_OTHER = 'other';

    const CATEGORIES = [
        self::CATEGORY_DIGITAL_GOODS,
        self::CATEGORY_CLOTHING,
        self::CATEGORY_PRESCRIPTION_DRUGS,
        self::CATEGORY_NON_PRESCRIPTION_DRUGS,
        self::CATEGORY_FOOD_GROCERIES,
        self::CATEGORY_SOFTWARE_SERVICES,
        self::CATEGORY_MAGAZINES,
        self::CATEGORY_MAGAZINE_SUBSCRIPTIONS,
        self::CATEGORY_BOOKS,
        self::CATEGORY_TEXTBOOKS,
        self::CATEGORY_RELIGIOUS_BOOKS,
        self::CATEGORY_OTHER,
    ];
}
