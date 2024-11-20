class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    document.querySelectorAll(".delete-note").forEach(button => {
      button.addEventListener("click", this.deleteNote.bind(this));
    });

    document.querySelectorAll(".edit-note").forEach(button => {
      // we need to bind 'this' or else JS will modify the value of 'this' and set it to equal
      // whatever element was clicked on
      button.addEventListener("click", this.editNote.bind(this));
    });

    document.querySelectorAll(".update-note").forEach(button => {
      button.addEventListener("click", this.updateNote.bind(this));
    });

    const submitNote = document.querySelector(".submit-note");
    submitNote.addEventListener("click", this.createNote.bind(this));
  }

  // Methods will go here
  editNote(e) {
    const thisNote = e.target.closest("li");
    if (thisNote.dataset.state === "editable") {
      console.log("reached read only");
      this.makeNoteReadOnly(thisNote);
    } else {
      console.log("reached editable");
      this.makeNoteEditable(thisNote);
    }
  }

  makeNoteEditable(thisNote) {
    // Update the edit button to "Cancel"
    const editNote = thisNote.querySelector(".edit-note");
    editNote.innerHTML = ` <i class="fa fa-times" aria-hidden="true"> </i> Cancel`;

    // Make title and body fields editable
    thisNote.querySelectorAll(".note-title-field, .note-body-field").forEach((field) => {
      field.removeAttribute("readonly");
      field.classList.add("note-active-field");
    });

    // Show the update button
    const updateNote = thisNote.querySelector(".update-note");
    updateNote.classList.add("update-note--visible");

    // Set the state to "editable"
    thisNote.dataset.state = "editable";
  }

  makeNoteReadOnly(thisNote) {
    // Update the edit button from "cancel" back to "Edit"
    const readOnlyNote = thisNote.querySelector(".edit-note");
    readOnlyNote.innerHTML = ` <i class="fa fa-pencil" aria-hidden="true"> </i> Edit`;

    // Make title and body fields read-only
    thisNote.querySelectorAll(".note-title-field, .note-body-field").forEach((field) => {
      field.classList.remove("note-active-field");
      field.setAttribute("readonly", true);
    });

    // Hide the update button
    const updateNote = thisNote.querySelector(".update-note");
    updateNote.classList.remove("update-note--visible");

    // Set the state to "read-only"
    thisNote.dataset.state = "read-only";
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

  updateNote(e) {
    const thisNote = e.target.closest("li");
    const ourUpdatedPost = {
      'title': thisNote.querySelector(".note-title-field").value,
      'content': thisNote.querySelector(".note-body-field").value
    };

    //The dataset property gives you access to all 'data-' attributes on an element
    fetch(universityData.root_url + 'wp-json/wp/v2/note/' + thisNote.dataset.id, {
      method: 'POST',
      headers: {
        'X-WP-Nonce': universityData.nonce,  // Set the nonce header for authorization
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(ourUpdatedPost)
    })
      .then((response) => { // Call success callback on any successful response
        if (!response.ok) {
          console.log("Sorry");
          console.log(response);
        } else {
          this.makeNoteReadOnly(thisNote);
          console.log("Congrats");
          console.log(response);
        }
      })
      .catch((error) => { // Call error callback on any failure
        console.log("Error:", error.message);
      });
  }

  createNote(e) {
    const ourNewPost = {
      'title': document.querySelector(".new-note-title").value,
      'content': document.querySelector(".new-note-body").value,
      'status': 'publish'
    };

    //The dataset property gives you access to all 'data-' attributes on an element
    fetch(universityData.root_url + 'wp-json/wp/v2/note/', {
      method: 'POST',
      headers: {
        'X-WP-Nonce': universityData.nonce,  // Set the nonce header for authorization
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(ourNewPost)
    })
      .then((response) => { // Call success callback on any successful response
        if (!response.ok) {
          console.log("Sorry");
          console.log(response);
        } else {
          document.querySelectorAll(".new-note-title .new-note-body").forEach(field => {
            field.value = '';
          });
          document.querySelector("#my-notes").insertAdjacentHTML("afterbegin", "<li>Imagine real data here</li>");

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