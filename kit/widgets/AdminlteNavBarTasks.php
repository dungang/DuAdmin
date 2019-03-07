<?php
namespace app\kit\widgets;

class AdminlteNavBarTasks extends AdminlteNavBarDropdownMenu
{

    protected function renderItem($item)
    {
        return '<a href="#">
                  <!-- Task title and progress text -->
                  <h3>
                    Design some buttons
                    <small class="pull-right">20%</small>
                  </h3>
                  <!-- The progress bar -->
                  <div class="progress xs">
                    <!-- Change the css width attribute to simulate progress -->
                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                         aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                      <span class="sr-only">20% Complete</span>
                    </div>
                  </div>
                </a>';
    }
}

