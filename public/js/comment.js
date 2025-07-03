// JavaScript for handling comment editing functionality

// Handle Edit Button Click
document.addEventListener("DOMContentLoaded", () => {
  const editButtons = document.getElementsByClassName("btn-edit");
  const commentText = document.getElementById("comment_type_form_content");
  const commentForm = document.getElementById("commentForm").closest("form");
  const submitButton = document.querySelector("#submitButton button");

  for (let button of editButtons) {
    button.addEventListener("click", (e) => {
      const commentId = button.getAttribute("data-comment_id");

      // Grab the comment text from the paragraph
      const commentContent = document.getElementById(`comment${commentId}`).innerText;

      // Inject it into the form
      commentText.value = commentContent;

      // Change form action to point to the backend comment edit route
      commentForm.setAttribute("action", `/comment/edit/${commentId}`);

      // Update submit button text
      submitButton.innerText = "Update Comment";

      // Scroll to form for better UX
      commentForm.scrollIntoView({ behavior: "smooth" });
    });
  }

  // Delete Comment Functionality
  const deleteConfirm = document.getElementById("deleteConfirm");
  const deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
  const deleteButtons = document.querySelectorAll(".btn-delete");

// Loop through each element in the NodeList of delete buttons
for (let button of deleteButtons) {

  // Add a click event listener to each delete button
  button.addEventListener("click", (e) => {
    // Prevent the default action of the button
    e.preventDefault();

    // Get the value of the 'data-comment_id' attribute from the clicked button
    const commentId = e.target.getAttribute("data-comment_id");

    // Set the 'action' attribute of the deleteConfirm form dynamically based on the comment ID
    deleteConfirm.href = `/comment/delete/${commentId}/`;

    // Show the Bootstrap modal to confirm deletion
    deleteModal.show();
  });
}

});
