class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    document.querySelectorAll(".delete-note").forEach(button => {
      button.addEventListener("click", this.deleteNote);
    });
  }

  // Methods will go here
  deleteNote() {
      fetch(universityData.root_url + 'wp-json/wp/v2/note/116', {
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