class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    document.querySelectorAll(".delete-note").forEach(button => {
      button.addEventListener("click", this.deleteNote);
    });

    document.querySelectorAll(".edit-note").forEach(button => {
      button.addEventListener("click", this.editNote);
    });
  }

  // Methods will go here
  editNote(e) {
    const thisNote = e.target.closest("li");
    thisNote.querySelectorAll(".note-title-field, .note-body-field").forEach((field) => {
      field.removeAttribute("readonly");
      field.classList.add("note-active-field");
    });
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