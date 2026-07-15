<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 2020-01-02 16:27
 * @File name           : _modal_topic.php
 * @Last modified by    : Ade Ismail Siregar (adeismailbox@gmail.com)
 * @Last modified time  : 2026-07-15T15:16:37+07:00
 */

?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="topicModalLabel"
     aria-hidden="true" inert>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="topicModalLabel"><?=  __('Select the topic you are interested in'); ?></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="topic d-flex flex-wrap justify-content-center p-0">
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=0&search=search" class="d-flex flex-column">
                            <i class="fas fa-desktop topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?=  __('Computer Science, Information & General Works'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=1&search=search" class="d-flex flex-column">
                            <i class="fas fa-lightbulb topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?=  __('Philosophy & Psychology'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=2&search=search" class="d-flex flex-column">
                            <i class="fas fa-heart topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?=  __('Religion'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=3&search=search" class="d-flex flex-column">
                            <i class="fas fa-users topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?=  __('Social Sciences'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=4&search=search" class="d-flex flex-column">
                            <i class="fas fa-language topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?=  __('Language'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=5&search=search" class="d-flex flex-column">
                            <i class="fas fa-calculator topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?=  __('Pure Science'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=6&search=search" class="d-flex flex-column">
                            <i class="fas fa-flask topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?=  __('Applied Sciences'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=7&search=search" class="d-flex flex-column">
                            <i class="fas fa-paint-brush topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?=  __('Art & Recreation'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=8&search=search" class="d-flex flex-column">
                            <i class="fas fa-book topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?=  __('Literature'); ?></span>
                        </a>
                    </li>
                    <li class="d-flex justify-content-center align-items-center m-2">
                        <a href="index.php?callnumber=9&search=search" class="d-flex flex-column">
                            <i class="fas fa-history topic-icon-fa mb-3 mx-auto" aria-hidden="true"></i>
                            <span><?=  __('History & Geography'); ?></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
