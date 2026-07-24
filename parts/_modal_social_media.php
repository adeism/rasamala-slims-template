<?php
/**
 * Backward Compatibility Wrapper for Social Media Share Modal
 * 
 * Note: All modal dialogs (Advanced Search, Topic Directory, and Social Share)
 * have been unified into `parts/modals.php`.
 * This file is kept to ensure legacy calls or external plugins including `_modal_social_media.php`
 * continue to work seamlessly.
 */
include_once __DIR__ . '/modals.php';
