<?php
namespace app\kit\widgets;

class AdminlteBarMessages extends AdminlteNavBarDropdownMenu
{

    protected function renderItem($item)
    {
        return '<a href="#">
                  <div class="pull-left">
                    <!-- User Image -->
                    <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                  </div>
                  <!-- Message title and timestamp -->
                  <h4>
                    Support Team
                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                  </h4>
                  <!-- The message -->
                  <p>Why not buy a new awesome theme?</p>
                </a>';
    }
}

