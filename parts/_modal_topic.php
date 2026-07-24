<?php
/**
 * Backward Compatibility Wrapper for Topic Directory Modal
 * 
 * Note: All modal dialogs (Advanced Search, Topic Directory, and Social Share)
 * have been unified into `parts/modals.php`.
 * This file is kept to ensure legacy calls or external plugins including `_modal_topic.php`
 * continue to work seamlessly.
 */
include_once __DIR__ . '/modals.php';
