// bagian awal dimana menunggu seluruh elemen html telah dimuat
document.addEventListener("DOMContentLoaded", () => {
  const chatBox = document.getElementById("chat-box");
  const chatForm = document.getElementById("chat-form");
  const receiverSelect = document.getElementById("receiver");
  const messageInput = document.getElementById("message");

  // Bagian untuk meload user dari server
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

  // bagian untuk meload chat dari user tertentu
  const formatDate = (timestamp) => {
    const options = { day: "2-digit", month: "2-digit", year: "numeric" };
    return new Date(timestamp).toLocaleDateString("id-ID", options);
  };

  const formatTime = (timestamp) => {
    const options = { hour: "2-digit", minute: "2-digit", hour12: false };
    return new Date(timestamp).toLocaleTimeString("id-ID", options);
  };

  const loadChat = () => {
    const receiver = receiverSelect.value.trim();
    chatBox.classList.toggle("hidden", !receiver);

    if (!receiver) return;

    fetch(`chat_handler.php?receiver=${encodeURIComponent(receiver)}`)
      .then((res) => res.json())
      .then((messages) => {
        let lastDate = null;
 
        chatBox.innerHTML = messages
          .map(({ sender, message, timestamp }) => {
            const date = formatDate(timestamp);
            const time = formatTime(timestamp);
            let dateLabel = "";

            if (date !== lastDate) {
              dateLabel = `<div class="date-label">${date}</div>`;
              lastDate = date;
            }

            return `
              ${dateLabel}
              <div class="chat-message ${
                sender === receiver ? "receiver" : "sender"
              }">
              ${message}<div class="timestamp">${time}</div>
              </div>`;
          })
          .join("");
        chatBox.scrollTop = chatBox.scrollHeight;
      });
  };

  loadUsers();
  receiverSelect.addEventListener("change", loadChat);

  // bagian untuk pengiriman pesan
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
