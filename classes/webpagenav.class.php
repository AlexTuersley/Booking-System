<?php 
/**
* Create a webpage with a navbar menu
* @author Alex Tuersley
*/
class WebPageWithNav extends WebPage {
    //Class variables
    private $nav;
    private $level;
    private $navItems;

    /**
     * function creates a header for the page
    * @param $pageHeading1 - string that is the header of the page
    */
    protected function set_header($pageHeading1,$Level) {
        $this->level = $Level;
        $this->set_nav();
        $nav = $this->nav;
        $this->header = <<<HEADER
        <header>
        <h1>$pageHeading1</h1>
        $nav
        </header>
        HEADER;
    }

    /**
     * function creates the navigation menu in html format
    * @param $listItems - array with all the headers for the menu
    */
    private function navHTML($listItems) {
    return <<<MYNAV
        <nav class="navbar">
        <ul class="navbar-nav">
        $listItems
        <ul>
        </nav>
        MYNAV;
    }

    /**
     * This generates the menu from the list passed through and sets the nav property to it
     * @param $navList - an array of arrays that contain the link title, link and an icon 
     */
    private function set_nav() {
      $navList = array(array("index.php","home","fa-address-book-o"),array("bookings.php","bookings","fa-book"),array("schedule.php","staff","fa-building"),array("user.php","user","fa-user"),array("index.php?signout","Sign out","fa-sign-out"));
      if($this->level > 1){
          $navList = array(array("index.php","home","fa-address-book-o"),array("bookings.php","bookings","fa-book"),array("schedule.php","schedule","fa-calendar"),array("user.php","user","fa-user"),array("index.php?signout","Sign out","fa-sign-out"));
          if($this->level > 2){
              $navList = array(array("index.php","home","fa-address-book-o"),array("bookings.php","bookings","fa-book"),array("schedule.php","schedule","fa-calendar"),array("department.php","department","fa-university"),array("user.php","users","fa-users"),array("user.php","user","fa-user"),array("index.php?signout","Sign out","fa-sign-out"));
          }
      }
      else{
        $navList = array(array("index.php","home","fa-address-book-o"),array("signin.php","Sign In","fa-sign-in"),array("Sign Up","signup.php?signup","fa-user-plus"));
      }
      foreach ($navList as $Item) {
          if($Item[1] == "home"){
              $listItems .= "<li class='logo'>
              <a href='".$Item[0]."' class='nav-link'>
              <span class='link-text logo-text'><Home</span>
              <svg
              aria-hidden='true'
              focusable='false'
              data-prefix='fad'
              role='img'
              xmlns='http://www.w3.org/2000/svg'
              viewBox='0 0 448 512'
              class='svg-inline--fa ".$Item[2]." fa-w-14 fa-5x>
              <g class='fa-group'>
              <path fill='currentColor'
                  d='M224 273L88.37 409a23.78 23.78 0 0 1-33.8 0L32 386.36a23.94 23.94 0 0 1 0-33.89l96.13-96.37L32 159.73a23.94 23.94 0 0 1 0-33.89l22.44-22.79a23.78 23.78 0 0 1 33.8 0L223.88 239a23.94 23.94 0 0 1 .1 34z'
                  class='fa-secondary'
              ></path>
              <path
                  fill='currentColor'
                  d='M415.89 273L280.34 409a23.77 23.77 0 0 1-33.79 0L224 386.26a23.94 23.94 0 0 1 0-33.89L320.11 256l-96-96.47a23.94 23.94 0 0 1 0-33.89l22.52-22.59a23.77 23.77 0 0 1 33.79 0L416 239a24 24 0 0 1-.11 34z'
                  class='fa-primary'
              ></path>
                      </g>
                  </svg>
                  </a>
              </li>";
          }
          else{
              $listItems .="<li class='nav-item'>
              <a href='".$Item[0]."' class='nav-link'>
                <svg
                  aria-hidden='true'
                  focusable='false'
                  data-prefix='fad'
                  role='img'
                  xmlns='http://www.w3.org/2000/svg'
                  viewBox='0 0 512 512'
                  class='svg-inline--fa ".$Item[2]." fa-w-16 fa-9x'
                >
                  <g class='fa-group'>
                    <path
                      fill='currentColor'
                      d='M448 96h-64l-64-64v134.4a96 96 0 0 0 192 0V32zm-72 80a16 16 0 1 1 16-16 16 16 0 0 1-16 16zm80 0a16 16 0 1 1 16-16 16 16 0 0 1-16 16zm-165.41 16a204.07 204.07 0 0 0-34.59 2.89V272l-43.15-64.73a183.93 183.93 0 0 0-44.37 26.17L192 304l-60.94-30.47L128 272v-80a96.1 96.1 0 0 0-96-96 32 32 0 0 0 0 64 32 32 0 0 1 32 32v256a64.06 64.06 0 0 0 64 64h176a16 16 0 0 0 16-16v-16a32 32 0 0 0-32-32h-32l128-96v144a16 16 0 0 0 16 16h32a16 16 0 0 0 16-16V289.86a126.78 126.78 0 0 1-32 4.54c-61.81 0-113.52-44.05-125.41-102.4z'
                      class='fa-secondary'
                    ></path>
                    <path
                      fill='currentColor'
                      d='M376 144a16 16 0 1 0 16 16 16 16 0 0 0-16-16zm80 0a16 16 0 1 0 16 16 16 16 0 0 0-16-16zM131.06 273.53L192 304l-23.52-70.56a192.06 192.06 0 0 0-37.42 40.09zM256 272v-77.11a198.62 198.62 0 0 0-43.15 12.38z'
                      class='fa-primary'
                    ></path>
                  </g>
                </svg>
                <span class='link-text'>".$Item[1]."</span>
              </a>
            </li>";
          }
      }
      $this->nav = $this->navHTML($listItems);
    }

}
?>