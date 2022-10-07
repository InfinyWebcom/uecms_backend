
	<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-dark gradient-45deg-purple-deep-orange sidenav-gradient sidenav-active-rounded">
        
        <div class="brand-sidebar">
            <h1 class="logo-wrapper">
        	<a class="brand-logo darken-1" href="<?php echo base_url(); ?>">
        		<img class="hide-on-med-and-down " src="<?php echo base_url(); ?>/app-assets/images/logo/materialize-logo.png" alt="materialize logo" />
        		<span class="logo-text hide-on-med-and-down">UECMS</span>
        	</a>
        </div>
        
        <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
            
            <li class="navigation-header">

            </li>

            <li class="bold">
            	<a class="waves-effect waves-cyan <?php if ($active == 'dashboard') echo 'active'; ?>" href="<?php echo base_url(); ?>">
            		<i class="material-icons">dashboard_outline</i>
            		<span class="menu-title" data-i18n="Chat">Dashboard</span>
            	</a>
            </li>

            <li class="bold">
            	<a class="waves-effect waves-cyan <?php if ($active == 'clients') echo 'active'; ?>" href="<?php echo base_url(); ?>home/clients">
            		<i class="material-icons">people</i>
            		<span class="menu-title" data-i18n="Chat">Clients</span>
            	</a>
            </li>

            <li class="bold">
            	<a class="waves-effect waves-cyan <?php if ($active == 'contracts') echo 'active'; ?>" href="<?php echo base_url(); ?>home/contracts">
            		<i class="material-icons">business_center</i>
            		<span class="menu-title" data-i18n="Chat">Workorder Contracts</span>
            	</a>
            </li>

            <li class="bold">
            	<a class="waves-effect waves-cyan <?php if ($active == 'staff') echo 'active'; ?>" href="<?php echo base_url(); ?>staff">
            		<i class="material-icons">person_pin</i>
            		<span class="menu-title" data-i18n="Chat">Staff</span>
            	</a>
            </li>
            <?php if($_SESSION['user_type'] == 'admin'){ ?>
                <li class="bold">
                	<a class="waves-effect waves-cyan <?php if ($active == 'inventory') echo 'active'; ?>" href="<?php echo base_url(); ?>user/inventory">
                		<i class="material-icons">layers</i>
                		<span class="menu-title" data-i18n="Chat">Inventory</span>
                	</a>
                </li>
            <?php } ?>
            
            
            <li class="bold <?php if ($active == 'contractExpenses' || $active == 'operationalExpenses') echo 'active'; ?>"><a class="collapsible-header waves-effect waves-cyan " href="#"><i class="material-icons">monetization_on</i><span class="menu-title" data-i18n="">Expenses</span></a>
              <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    <li>
                        <a class="collapsible-body <?php if ($active == 'contractExpenses') echo 'active'; ?>" href="<?php echo base_url(); ?>user/contractExpenses" data-i18n=""><i class="material-icons">radio_button_unchecked</i>
                            <span>Contract Expenses</span>
                        </a>
                    </li>
                    <?php if($_SESSION['user_type'] == 'admin'){ ?>
                      <li>
                        <a class="collapsible-body <?php if ($active == 'operationalExpenses') echo 'active'; ?>" href="<?php echo base_url(); ?>user/operationalExpenses" data-i18n=""><i class="material-icons">radio_button_unchecked</i>
                            <span>Operational Expenses</span>
                        </a>
                      </li>
                    <?php } ?>
                </ul>
              </div>
            </li>
            


            <li class="bold">
                <a class="waves-effect waves-cyan <?php if ($active == 'measurements') echo 'active'; ?>" href="<?php echo base_url(); ?>user/measurements">
                    <i class="material-icons">assignment</i>
                    <span class="menu-title" data-i18n="Chat">Measurements</span>
                </a>
            </li>

            <li class="bold">
                <a class="waves-effect waves-cyan <?php if ($active == 'bills') echo 'active'; ?>" href="<?php echo base_url(); ?>user/bills">
                    <i class="material-icons">account_balance</i>
                    <span class="menu-title" data-i18n="Chat">Contract Bills</span>
                </a>
            </li>

            <li class="bold">
                <a class="waves-effect waves-cyan <?php if ($active == 'materialOrders') echo 'active'; ?>" href="<?php echo base_url(); ?>user/materialOrders">
                    <i class="material-icons">reorder</i>
                    <span class="menu-title" data-i18n="Chat">Material Orders</span>
                </a>
            </li>
        </ul>
        <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
    </aside>
    <!-- END: SideNav-->
