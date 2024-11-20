class MyNotes {
  constructor() {
    this.events();
  }

  events() {
    document.querySelectorAll(".delete-note").forEach(button => {
      button.addEventListener("click", this.deleteNote)
    });
  }

  // Methods will go here
  deleteNote() {
    alert("you clicked delete")
  }
}

export default MyNotes;