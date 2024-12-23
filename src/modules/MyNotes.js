class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    document.querySelector("#my-notes").addEventListener("click", function (e) {
      if (e.target.classList.contains("delete-note")) {
        this.deleteNote(e);
      }
    }.bind(this));

    document.querySelector("#my-notes").addEventListener("click", function (e) {
      if (e.target.classList.contains("edit-note")) {
        this.editNote(e);
      }
      // we need to bind 'this' or else JS will modify the value of 'this' and set it to equal
      // whatever element was clicked on
    }.bind(this));

    document.querySelector("#my-notes").addEventListener("click", function (e) {
      if (e.target.classList.contains("update-note")) {
        this.updateNote(e);
      }
    }.bind(this));

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
    thisNote.querySelector(".edit-note").innerHTML = `<i class="fa fa-times" aria-hidden="true"></i> Cancel
    `;

    // Make title and body fields editable
    thisNote.querySelector(".note-title-field").removeAttribute("readonly");
    thisNote.querySelector(".note-body-field").removeAttribute("readonly");
    thisNote.querySelector(".note-title-field").addAttribute("note-active-field");
    thisNote.querySelector(".note-body-field").addAttribute("note-active-field");

    // Show the update button
    thisNote.querySelector(".update-note").classList.add("update-note--visible");

    // Set the state to "editable"
    thisNote.setAttribute("data-state", "editable");
  }

  makeNoteReadOnly(thisNote) {
    // Update the edit button from "cancel" back to "Edit"
    thisNote.querySelector(".edit-note").innerHTML = `<i class="fa fa-pencil" aria-hidden="true"></i> Edit`;

    // Make title and body fields read-only
    thisNote.querySelector(".note-title-field").remove("note-active-field")
    thisNote.querySelector(".note-body-field").remove("note-active-field")
    thisNote.querySelector(".note-title-field").setAttribute("readonly", true);
    thisNote.querySelector(".note-body-field").setAttribute("readonly", true);

    // Hide the update button
    thisNote.querySelector(".update-note").classList.remove("update-note--visible");

    // Set the state to "read-only"
    thisNote.setAttribute("data-state", "read-only");
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
          thisNote.remove();
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
          return response.json().then((errorData) => {
            console.error("Error details:", errorData);
            throw new Error(`HTTP status ${response.status}`);
          });
        } else {
          return response.json();
        }
      })
      .then((data) => {
        this.makeNoteReadOnly(thisNote);
        console.log("Congrats");
        console.log("Parsed Response:", data);
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
          return response.json().then((errorData) => {
            if (errorData.data === "You have reached your note limit.") {
              document.querySelector(".note-limit-message").classList.add("active");
            }
            throw new Error(errorData.data || `HTTP status ${response.status}`);
          });
        }
        return response.json();
      })
      .then(data => {
        {
          document.querySelectorAll(".new-note-title, .new-note-body").forEach(field => {
            field.value = '';
          });
          document.querySelector("#my-notes").insertAdjacentHTML("afterbegin", `
            <li data-id="${data.id}">
              <input readonly class="note-title-field" value="${data.title.raw}">
              <span class="edit-note">
                <i class="fa fa-pencil" aria-hidden="true"> </i>
                Edit
              </span>
              <span class="delete-note">
                <i class="fa fa-trash-o" aria-hidden="true"></i>
                Delete
              </span>
              <textarea readonly class="note-body-field">${data.content.raw}</textarea>
              <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i>Save</span>
            </li>
            `);

          console.log("Congrats");
          console.log(data);
        }
      })
      .catch((error) => { // Call error callback on any failure
        console.error("Error:", error.message);
      });
  }
}

export default MyNotes;