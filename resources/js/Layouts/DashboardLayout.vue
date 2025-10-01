<template>
  <LoadingBar />
  <div class="wrapper" :class="{ 'sidebar-collapse': sidebarCollapsed, 'sidebar-open': sidebarOpen && isMobile }">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#" role="button" @click.prevent="toggleSidebar"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#" class="nav-link">Home</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Theme Switcher -->
        <li class="nav-item">
          <a class="nav-link" href="#" role="button" @click.prevent="toggleDarkMode">
            <i :class="darkMode ? 'fas fa-sun' : 'fas fa-moon'"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" role="button" @click.prevent="toggleFullscreen">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" id="userDropdown" role="button" @click.prevent="toggleUserDropdown" :aria-expanded="userDropdownOpen">
            <i class="fas fa-user-circle"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" :class="{ show: userDropdownOpen }" aria-labelledby="userDropdown">
            <div class="dropdown-header text-center pb-2 pt-2 border-bottom">
              <strong>{{ user?.name || 'Administrator' }}</strong>
            </div>
            <Link :href="route('profile.edit')" class="dropdown-item py-2" @click="userDropdownOpen = false">
              <i class="fas fa-user mr-2 text-primary"></i> My Profile
            </Link>
            <a href="#" class="dropdown-item py-2">
              <i class="fas fa-cog mr-2 text-secondary"></i> Settings
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item py-2" @click.prevent="logout">
              <i class="fas fa-sign-out-alt mr-2 text-danger"></i> Sign Out
            </a>
          </div>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="/" class="brand-link text-center py-3">
        <img src="/images/logo.png" alt="Azam TV Logo" class="img-fluid" style="max-width: 140px; margin-bottom: 5px; display: block; margin-left: auto; margin-right: auto;">
        <!-- <span class="brand-text font-weight-bold" style="font-size: 1.2rem;">SMS</span> -->
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel with dropdown -->
        <div class="user-panel mt-3 pb-2 mb-2">
          <div class="d-flex align-items-center">
            <div class="image pl-2">
              <i class="fas fa-user-circle fa-2x text-light"></i>
            </div>
            <div class="info">
              <a href="#" class="d-block dropdown-toggle" @click.prevent="toggleSidebarUserPanel">
                {{ user?.name || 'Administrator' }}
              </a>
            </div>
          </div>
          
          <!-- User options dropdown -->
          <div id="userOptions" class="mt-2" :class="{ 'd-none': !sidebarUserPanelOpen }">
            <div class="bg-dark rounded p-2 ml-2">
              <Link :href="route('profile.edit')" class="text-white d-block py-1 px-2 rounded hover-bg-light" @click="sidebarUserPanelOpen = false">
                <i class="fas fa-user-edit mr-2"></i> Edit Profile
              </Link>
              <a href="#" class="text-white d-block py-1 px-2 rounded hover-bg-light" @click.prevent="logout">
                <i class="fas fa-sign-out-alt mr-2"></i> Logout
              </a>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <Link :href="route('home.dashboard')" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </Link>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-sms"></i>
                <p>
                  SMS Management
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/sms/send" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Send SMS</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/sms/templates" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>SMS Templates</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/sms/logs" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>SMS Logs</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="/recipients" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>Recipients</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/settings" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>Settings</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content with no header or title -->
      <div class="content pt-4">
        <div class="container-fluid">
          <slot></slot>
        </div>
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <strong>Copyright &copy; {{ new Date().getFullYear() }} <a href="#">UPG MIS</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, onBeforeUnmount } from 'vue';
import { router, usePage, Link } from '@inertiajs/vue3';
import LoadingBar from '@/Components/LoadingBar.vue';

const props = defineProps({
  title: {
    type: String,
    default: 'Dashboard'
  }
});

// Reactive variables for UI state
const sidebarCollapsed = ref(false);
const sidebarOpen = ref(false); // For mobile view
const isMobile = ref(window.innerWidth < 992);
const activeMenuItem = ref('');
const openMenus = ref([]); // All menus collapsed by default
const userDropdownOpen = ref(false);
const sidebarUserPanelOpen = ref(false);
const darkMode = ref(localStorage.getItem('darkMode') === 'true');

// Get the authenticated user from Laravel
const user = computed(() => usePage().props.auth.user);

// Toggle sidebar collapsed/open state
function toggleSidebar() {
  if (isMobile.value) {
    // On mobile, toggle the sidebar-open class
    sidebarOpen.value = !sidebarOpen.value;
  } else {
    // On desktop, toggle the sidebar-collapse class
    sidebarCollapsed.value = !sidebarCollapsed.value;
  }
}

// Toggle menu item expansion
function toggleMenu(menuName) {
  if (openMenus.value.includes(menuName)) {
    openMenus.value = openMenus.value.filter(name => name !== menuName);
  } else {
    openMenus.value.push(menuName);
  }
}

// Check if a menu is open
function isMenuOpen(menuName) {
  return openMenus.value.includes(menuName);
}

// Toggle user dropdown
function toggleUserDropdown() {
  userDropdownOpen.value = !userDropdownOpen.value;
}

// Toggle fullscreen
function toggleFullscreen() {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen();
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    }
  }
}

// Toggle sidebar user panel
function toggleSidebarUserPanel() {
  sidebarUserPanelOpen.value = !sidebarUserPanelOpen.value;
}

// Logout function
function logout() {
  router.post(route('logout'));
}

// Go to profile function
function goToProfile() {
  userDropdownOpen.value = false;
  sidebarUserPanelOpen.value = false;
  router.visit(route('profile.edit'));
}

// Set active menu item based on current route
function setActiveMenuItem() {
  const currentUrl = window.location.pathname;
  activeMenuItem.value = currentUrl;

  // Automatically expand parent menus if they contain the active item
  if (currentUrl.includes('/sms') && !openMenus.value.includes('sms')) {
    openMenus.value.push('sms');
  }
}

// Toggle dark mode
function toggleDarkMode() {
  darkMode.value = !darkMode.value;
  localStorage.setItem('darkMode', darkMode.value.toString());
  applyTheme();
}

// Apply theme function
function applyTheme() {
  // Toggle dark mode class on body
  document.body.classList.toggle('dark-mode', darkMode.value);

  // Update navbar classes based on theme
  const navbar = document.querySelector('.main-header');
  if (navbar) {
    if (darkMode.value) {
      navbar.classList.add('navbar-dark');
      navbar.classList.remove('navbar-light', 'navbar-white');
    } else {
      navbar.classList.remove('navbar-dark');
      navbar.classList.add('navbar-light', 'navbar-white');
    }
  }
}

// Handle clicks outside dropdowns to close them
function handleClickOutside(e) {
  // Don't interfere with Link components
  if (e.target.closest('a[href]') || e.target.closest('[data-inertia]')) {
    return;
  }

  // Close user dropdown if clicking outside
  const userDropdownToggle = document.getElementById('userDropdown');
  const dropdownMenu = document.querySelector('.dropdown-menu');

  if (userDropdownOpen.value &&
      userDropdownToggle &&
      !userDropdownToggle.contains(e.target) &&
      (!dropdownMenu || !dropdownMenu.contains(e.target))) {
    userDropdownOpen.value = false;
  }

  // Close sidebar user panel if clicking outside
  const sidebarUserPanel = document.getElementById('userOptions');
  const sidebarUserToggle = document.querySelector('.sidebar .dropdown-toggle');

  if (sidebarUserPanelOpen.value &&
      sidebarUserPanel &&
      sidebarUserToggle &&
      !sidebarUserPanel.contains(e.target) &&
      !sidebarUserToggle.contains(e.target)) {
    sidebarUserPanelOpen.value = false;
  }
}

// Handle window resize
function handleResize() {
  isMobile.value = window.innerWidth < 992;

  // Reset sidebar state on resize
  if (!isMobile.value) {
    sidebarOpen.value = false;
  }
}

// Initialize component
onMounted(() => {
  // Apply theme on component mount
  applyTheme();

  // Set active menu item
  setActiveMenuItem();

  // Add event listeners
  document.addEventListener('click', handleClickOutside);
  window.addEventListener('resize', handleResize);

  // Note: Removed router event handlers that were interfering with navigation
});

// Clean up event listeners when component is unmounted
onBeforeUnmount(() => {
  document.removeEventListener('click', handleClickOutside);
  window.removeEventListener('resize', handleResize);
});
</script>

<style>
/* Ultimate fix for menu alignment and arrows */
.nav-sidebar .nav-link {
  display: flex !important;
  align-items: center !important;
  position: relative !important;
  padding-right: 30px !important; /* Ensure space for arrow */
}

.nav-sidebar .nav-link .nav-icon {
  margin-right: 0.5rem !important;
  align-self: center !important;
}

.nav-sidebar .nav-link p {
  display: flex !important;
  align-items: center !important;
  margin-bottom: 0 !important;
  overflow: visible !important;
}

/* Force the arrow to be absolutely positioned and stay in place */
.nav-sidebar .nav-item .nav-link .right, 
.nav-sidebar .nav-item .nav-link p .fa-angle-left.right,
.nav-sidebar .nav-item .nav-link p > i.right,
.nav-treeview .nav-item .nav-link p > i.right {
  position: absolute !important;
  right: 10px !important;
  top: 50% !important;
  transform: translateY(-50%) !important;
  transition: transform 0.3s ease !important;
  margin: 0 !important;
  padding: 0 !important;
  float: none !important;
  line-height: 1 !important;
}

/* Fix arrow rotation animation when menu opens */
.nav-sidebar .nav-item.menu-open > .nav-link .fa-angle-left.right,
.nav-sidebar .nav-item.menu-is-opening > .nav-link .fa-angle-left.right {
  transform: translateY(-50%) rotate(-90deg) !important;
}

/* Override any AdminLTE hover states that might affect positioning */
.nav-sidebar .nav-link:hover .right,
.nav-sidebar .nav-link:focus .right,
.nav-sidebar .nav-link:active .right {
  position: absolute !important;
  right: 10px !important;
  top: 50% !important;
  transform: translateY(-50%) !important;
}

/* Custom styling for the dashboard layout */
.hover-bg-light:hover {
  background-color: rgba(255, 255, 255, 0.1);
  transition: background-color 0.2s;
}

/* Dark mode enhancements */
body.dark-mode {
  /* Main background and text colors */
  background-color: #121212;
  color: #f8f9fa;
}

/* Dark mode card styling */
body.dark-mode .card {
  background-color: #1e1e1e;
  border-color: #2c2c2c;
}

body.dark-mode .card-header {
  background-color: #2a2a2a;
  border-bottom-color: #333;
}

body.dark-mode .card-footer {
  background-color: #2a2a2a;
  border-top-color: #333;
}

/* Dark mode content wrapper */
body.dark-mode .content-wrapper {
  background-color: #121212;
}

/* Dark mode table styling */
body.dark-mode .table {
  color: #e0e0e0;
}

body.dark-mode .table-bordered {
  border-color: #333;
}

body.dark-mode .table-bordered td,
body.dark-mode .table-bordered th {
  border-color: #333;
}

body.dark-mode .table-hover tbody tr:hover {
  background-color: rgba(255, 255, 255, 0.075);
}

/* Dark mode input styling */
body.dark-mode .form-control {
  background-color: #2a2a2a;
  border-color: #444;
  color: #e0e0e0;
}

body.dark-mode .form-control:focus {
  background-color: #323232;
  border-color: #666;
  box-shadow: 0 0 0 0.2rem rgba(130, 138, 145, 0.25);
}

/* Dark mode footer */
body.dark-mode .main-footer {
  background-color: #1a1a1a;
  border-top-color: #333;
  color: #e0e0e0;
}

/* Dark mode modal styling */
body.dark-mode .modal-content {
  background-color: #2a2a2a;
  border-color: #444;
}

body.dark-mode .modal-header,
body.dark-mode .modal-footer {
  border-color: #444;
}

/* Dark mode toast/alert styling */
body.dark-mode .toast {
  background-color: #2a2a2a;
  border-color: #444;
}

body.dark-mode .alert-success {
  background-color: rgba(40, 167, 69, 0.2);
  border-color: rgba(40, 167, 69, 0.3);
  color: #75b798;
}

body.dark-mode .alert-danger {
  background-color: rgba(220, 53, 69, 0.2);
  border-color: rgba(220, 53, 69, 0.3);
  color: #ea868f;
}

/* Dark mode dropdown styling */
body.dark-mode .dropdown-menu {
  background-color: #2a2a2a;
  border-color: #444;
}

body.dark-mode .dropdown-item {
  color: #e0e0e0;
}

body.dark-mode .dropdown-item:hover {
  background-color: #333;
  color: #fff;
}

body.dark-mode .dropdown-divider {
  border-color: #444;
}

/* Make sure dropdown toggle has a pointer cursor */
.dropdown-toggle {
  cursor: pointer;
}

/* Add some animation to the dropdown */
#userOptions {
  transition: all 0.3s ease;
}

/* Dropdown styles for navbar user menu */
.dropdown-menu.show {
  display: block;
  transform: translate3d(0, 38px, 0) !important;
  top: 0 !important;
  right: 0 !important;
  left: auto !important;
  animation: fadeIn 0.2s ease-in;
}

.dropdown-item {
  transition: background-color 0.2s;
}

.dropdown-item:hover {
  background-color: #f8f9fa;
}

.dropdown-header {
  color: #6c757d;
  background-color: #f8f9fa;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
