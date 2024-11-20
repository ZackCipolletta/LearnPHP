class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    document.querySelectorAll(".delete-note").forEach(button => {
      button.addEventListener("click", this.deleteNote);
    });

    document.querySelectorAll(".edit-note").forEach(button => {
      // we need to bind 'this' or else JS will modify the value of 'this' and set it to equal
      // whatever element was clicked on
      button.addEventListener("click", this.editNote.bind(this));
    });
  }

  // Methods will go here
  editNote(e) {
    const thisNote = e.target.closest("li");
    if (thisNote.dataset.state === "editable") {
      this.makeNoteReadOnly(thisNote);
    } else {
      this.makeNoteEditable(thisNote);
    }
  }

  makeNoteEditable(thisNote) {
    thisNote.querySelectorAll(".edit-note").forEach(element => {
      element.innerHTML = ` <i class="fa fa-times" aria-hidden="true"> </i> Cancel`;
    });
    thisNote.querySelectorAll(".note-title-field, .note-body-field").forEach((field) => {
      field.removeAttribute("readonly");
      field.classList.add("note-active-field");
    });
    thisNote.querySelectorAll(".update-note").forEach((field) => {
      field.classList.add("update-note--visible");
    });
    thisNote.dataset.state === "editable";
  }

  makeNoteReadOnly(thisNote) {
    thisNote.querySelectorAll(".edit-note").forEach(element => {
      element.innerHTML = ` <i class="fa fa-pencil" aria-hidden="true"> </i> Edit`;
    });
    thisNote.querySelectorAll(".note-title-field, .note-body-field").forEach((field) => {
      field.removeAttribute("note-active-field");
      field.classList.add("readonly");
    });
    thisNote.querySelectorAll(".update-note").forEach((field) => {
      field.removeAttribute("update-note--visible");
    });
    thisNote.dataset.state === "cancel";
  }


  deleteNote(e) {
    const thisNote = e.target.closest("li");

    //The dataset property gives you access to all 'data-' attributes on an element
    fetch(universityData.root_url + 'wp-json/wp/v2/note/' + thisNote.dataset.id, {
      method: 'DELETE',
      headers: {
        'X-WP-Nonce': universityData.nonce,  // Set the nonce header for authorization
        'Content-Type': 'application/json'
      }
    })
      .then((response) => { // Call success callback on any successful response
        if (!response.ok) {
          console.log("Sorry");
          console.log(response);
        } else {

          console.log("Congrats");
          console.log(response);
        }
      })
      .catch((error) => { // Call error callback on any failure
        console.log("Error:", error.message);

      });
  }
}

export default MyNotes;