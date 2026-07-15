<div id="chat-btn" onclick="toggleChat()"
     style="position:fixed;bottom:24px;right:24px;
  width:56px;height:56px;border-radius:50%;
  background:#1F4E79;color:white;border:none;
  cursor:pointer;font-size:24px;display:flex;
  align-items:center;justify-content:center;
  box-shadow:0 4px 12px rgba(0,0,0,0.15);z-index:1000">
    💬
</div>

<div id="chat-box" style="display:none;position:fixed;
  bottom:90px;right:24px;width:340px;height:440px;
  background:white;border-radius:12px;
  box-shadow:0 8px 32px rgba(0,0,0,0.15);
  flex-direction:column;z-index:999">

    <div style="background:#1F4E79;color:white;padding:14px 16px;
    border-radius:12px 12px 0 0;font-weight:500">
        🛍️ Shop Assistant
    </div>

    <div id="chat-messages" style="flex:1;overflow-y:auto;
    padding:12px;display:flex;flex-direction:column;gap:8px">
        <div class="bot-msg">Hi! How can I help you today?</div>
    </div>

    <div style="padding:10px;border-top:1px solid #eee;display:flex;gap:8px">
        <input id="chat-input" type="text"
               placeholder="Ask about our products..."
               onkeydown="if(event.key==='Enter') sendMessage()"
               style="flex:1;padding:8px 12px;border:1px solid #ddd;
      border-radius:20px;font-size:13px;outline:none" />
        <button onclick="sendMessage()"
                style="background:#1F4E79;color:white;border:none;
      border-radius:50%;width:36px;height:36px;cursor:pointer">
            ➤
        </button>
    </div>
</div>

<script>
    function toggleChat() {
        const box = document.getElementById('chat-box');
        box.style.display = box.style.display === 'none' ? 'flex' : 'none';
    }

    let conversationHistory = [];

    async function sendMessage() {
        const input   = document.getElementById('chat-input');
        const msgs    = document.getElementById('chat-messages');
        const message = input.value.trim();
        if (!message) return;

        msgs.innerHTML += `<div style="text-align:right;
    background:#1F4E79;color:white;padding:8px 12px;
    border-radius:12px;font-size:13px;max-width:80%;
    margin-left:auto">${message}</div>`;
        input.value = '';
        msgs.scrollTop = msgs.scrollHeight;

        msgs.innerHTML += `<div id="typing"
    style="color:#888;font-size:12px;padding:4px">typing...</div>`;

        // Add user message to history
        conversationHistory.push({
            role: 'user',
            content: message
        });

        const res  = await fetch('/api/assistant/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ messages: conversationHistory })
        });

        const data = await res.json();
        // Add AI response to history too
        conversationHistory.push({
            role: 'assistant',
            content: data.reply
        });

        document.getElementById('typing').remove();

        msgs.innerHTML += `<div style="background:#f1f5f9;
    padding:8px 12px;border-radius:12px;
    font-size:13px;max-width:85%">${data.reply}</div>`;
        msgs.scrollTop = msgs.scrollHeight;
    }
</script>
