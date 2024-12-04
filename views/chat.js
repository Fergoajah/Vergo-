document.addEventListener("DOMContentLoaded", () => {
    const chatBox = document.getElementById("chat-box");
    const chatForm = document.getElementById("chat-form");
    const receiverSelect = document.getElementById("receiver");
    const messageInput = document.getElementById("message");

    const loadUsers = () => {
      fetch("users_handler.php")
        .then((response) => response.json())
        .then((users) => {
          users.forEach((user) => {
            const option = new Option(user.username, user.username);
            receiverSelect.add(option);
          });
        });
    };

    const loadChat = () => {
        const receiver = receiverSelect.value.trim();
        chatBox.classList.toggle("hidden", !receiver); // Tampilkan atau sembunyikan chatbox
    
        if (receiver) {
            fetch(`chat_handler.php?receiver=${encodeURIComponent(receiver)}`)
                .then((response) => response.json())
                .then((messages) => {
                    chatBox.innerHTML = messages
                        .map((msg) => {
                            const messageClass = msg.sender === receiver ? 'receiver' : 'sender';
                            return `<div class="chat-message ${messageClass}">
                                        <strong>${msg.sender}:</strong><br> 
                                        ${msg.message} 
                                        <small style="color: gray;">[${msg.timestamp}]</small>
                                    </div>`;
                        })
                        .join("");
                    chatBox.scrollTop = chatBox.scrollHeight; // Auto scroll ke bawah
                });
        }
    };
    loadUsers();
    receiverSelect.addEventListener("change", loadChat);

    chatForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const receiver = receiverSelect.value.trim();
      const message = messageInput.value.trim();

      if (receiver && message) {
        fetch("chat_handler.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `receiver=${encodeURIComponent(
            receiver
          )}&message=${encodeURIComponent(message)}`,
        }).then(() => {
          messageInput.value = ""; // Kosongkan input pesan
          loadChat(); // Reload chat
        });
      }
    });
  });