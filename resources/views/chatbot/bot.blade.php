<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/css/bot.css"/>
    <link rel="stylesheet" href="https://kit.fontawesome.com/8d1be3a7c9.js" crossorigin="anonymous">
</head>

<div class="chatbot-wrapper">
    <button class="chatbot-toggle" id="chatbot-toggle">
      <img src="images/chatbot.jpg" class="chatbot-img">
    </button>
    <div class="chatbot-window" id="chatbot-window">
      <div class="chatbot-header">
        <h3 class="chatbot-title">MFA Customs Brokerage</h3>
        <button class="chatbot-close"  id="chatbot-close-btn">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18px" height="18px"><path d="M18 6.41L17.59 6 12 11.59 6.41 6 6 6.41 11.59 12 6 17.59 6.41 18 12 12.41 17.59 18 18 17.59 12.41 12z"/></svg>
        </button>
      </div>
      <div class="chatbot-body" id="chatbot-body">
        <div class="chatbot-messages" id="chatbot-messages"></div>
          <div class="chatbot-field">
          </div>
      </div>
      <input type="text" id="chatbot-input" placeholder="Type your message here...">
    </div>
  </div>

  <!-- Add this script tag before the closing body tag -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/guzzle.js/5.3.0/guzzle.min.js"></script>


<script src="https://kit.fontawesome.com/8d1be3a7c9.js" crossorigin="anonymous"></script>
<!-- Script for chatbot functionality -->
<script>
    // Get elements from DOM
    const chatbotToggle = document.getElementById("chatbot-toggle");
    const chatbotWindow = document.getElementById("chatbot-window");
    const chatbotCloseBtn = document.getElementById("chatbot-close-btn");
    const chatbotInput = document.getElementById("chatbot-input");
    const chatbotBody = document.getElementById("chatbot-body");

    // Function to create user message element
    function createUserMessageElement(message) {
      const userMessageContainer = document.createElement("div");
      userMessageContainer.classList.add("user-message-container");
      const userMessage = document.createElement("div");
      userMessage.classList.add("user-message");
      userMessage.textContent = message;
      userMessageContainer.appendChild(userMessage);
      return userMessageContainer;
    }

    // Function to create chatbot message element
    function createChatbotMessageElement(message) {
      const chatbotMessageContainer = document.createElement("div");
      chatbotMessageContainer.classList.add("chatbot-message-container");
      const chatbotMessage = document.createElement("div");
      chatbotMessage.classList.add("chatbot-message");
      chatbotMessage.textContent = message;
      chatbotMessageContainer.appendChild(chatbotMessage);
      return chatbotMessageContainer;
    }

    // Function to add message to chatbot body
    function addMessageToChatbotBody(messageElement) {
      chatbotBody.appendChild(messageElement);
      chatbotBody.scrollTop = chatbotBody.scrollHeight;
    }

    // Function to send user input to backend and get chatbot response
    function sendUserInputToBackend(userInput) {
      const formData = new FormData();
      formData.append("message", userInput);
      guzzle.post("/chatbot", { body: formData }).then((response) => {
        const chatbotResponse = response.body.response;
        const chatbotMessageElement = createChatbotMessageElement(chatbotResponse);
        addMessageToChatbotBody(chatbotMessageElement);
      });
    }

    // Event listener for chatbot toggle button
    chatbotToggle.addEventListener("click", () => {
      if (chatbotWindow.style.display === "none") {
        chatbotWindow.style.display = "flex";
        chatbotInput.focus();
      } else {
        chatbotWindow.style.display = "none";
      }
    });

    // Event listener for chatbot close button
    chatbotCloseBtn.addEventListener("click", () => {
      chatbotWindow.style.display = "none";
    });

    // Event listener for chatbot input
    chatbotInput.addEventListener("keydown", (event) => {
      if (event.key === "Enter") {
        const userInput = chatbotInput.value.trim();
        if (userInput) {
          const userMessageElement = createUserMessageElement(userInput);
          addMessageToChatbotBody(userMessageElement);
          chatbotInput.value = "";

          // Send user input to backend and get chatbot response
          sendUserInputToBackend(userInput);
        }
      }
    });
  </script>


    {{-- For Testing purposes
    // Mock backend response
    function mockBackendResponse(userInput) {
    const response = "You said: " + userInput;
    return Promise.resolve({ body: { response } });
    }

    // Function to send user input to mock backend and get chatbot response
    function sendUserInputToBackend(userInput) {
    mockBackendResponse(userInput).then((response) => {
        const chatbotResponse = response.body.response;
        const chatbotMessageElement = createChatbotMessageElement(chatbotResponse);
        addMessageToChatbotBody(chatbotMessageElement);
    });
    } --}}
