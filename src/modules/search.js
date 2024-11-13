import $ from 'jquery';

class Search {
  // 1. describe and create/initiate our object
  constructor() {
    this.openButton = $(".js-search-trigger");
    this.closeButton = $(".search-overlay__close");
    this.searchOverlay = $(".search-overlay");
    this.events();
    this.isOverlayOpen = false;
  }
  // 2. events
  events() {
    this.openButton.on("click", this.openOverlay.bind(this));
    this.closeButton.on("click", this.closeOverly.bind(this));

    $(document).on("keydown", this.keyPressDispatcher.bind(this));
  }

  // 3. methods (functions, actions..)
  keyPressDispatcher(e) {
    if (e.keyCode === 83 && !this.isOverlayOpen) {
      this.openOverlay();
    }

    if (e.keyCode === 27 && this.isOverlayOpen) {
      this.closeOverly();
    }
  }

  openOverlay() {
    this.searchOverlay.addClass("search-overlay--active");
    $("body").addClass("body-no-scroll");
    console.log("our open method just ran")
    this.isOverlayOpen = true;
  }

  closeOverly() {
    this.searchOverlay.removeClass("search-overlay--active");
    $("body").removeClass("body-no-scroll");
    console.log("our close method just ran")
    this.isOverlayOpen = false;
  }
}

export default Search;