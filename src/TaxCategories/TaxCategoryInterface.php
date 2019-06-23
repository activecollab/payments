<?php

/*
 * This file is part of the Active Collab Payments project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\Payments\TaxCategories;

use ActiveCollab\Object\ObjectInterface;

interface TaxCategoryInterface extends ObjectInterface
{
    const DIGITAL_GOODS = 'digital_goods';
    const CLOTHING = 'clothing';
    const PRESCRIPTION_DRUGS = 'prescription_drugs';
    const NON_PRESCRIPTION_DRUGS = 'non_prescription_drugs';
    const FOOD_GROCERIES = 'food_groceries';
    const SOFTWARE_SERVICES = 'software_services';
    const MAGAZINES = 'magazines';
    const MAGAZINE_SUBSCRIPTIONS = 'magazine_subscriptions';
    const BOOKS = 'books';
    const TEXTBOOKS = 'textbooks';
    const RELIGIOUS_BOOKS = 'religious_books';
    const OTHER = 'other';

    const CATEGORIES = [
        self::DIGITAL_GOODS,
        self::CLOTHING,
        self::PRESCRIPTION_DRUGS,
        self::NON_PRESCRIPTION_DRUGS,
        self::FOOD_GROCERIES,
        self::SOFTWARE_SERVICES,
        self::MAGAZINES,
        self::MAGAZINE_SUBSCRIPTIONS,
        self::BOOKS,
        self::TEXTBOOKS,
        self::RELIGIOUS_BOOKS,
        self::OTHER,
    ];

    public function getTaxCategory(): string;
}
