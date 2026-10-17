<!-- Floating AI chat widget. Included at the bottom of navbar.php so it shows on every page. -->
<style>
#bhChatBtn{
    position:fixed;bottom:22px;right:22px;width:58px;height:58px;border-radius:50%;
    border:none;cursor:pointer;font-size:26px;z-index:99999;color:#fff;
    background:linear-gradient(135deg,#ff8c00,#ff5722);box-shadow:0 6px 20px rgba(0,0,0,.35);
}
#bhChat{
    position:fixed;bottom:92px;right:22px;width:340px;max-width:calc(100vw - 30px);
    background:#fff;border-radius:16px;box-shadow:0 10px 40px rgba(0,0,0,.35);
    font-family:'Poppins',sans-serif;z-index:99999;display:none;flex-direction:column;overflow:hidden;
}
#bhChat .bh-head{background:linear-gradient(135deg,#ff8c00,#ff5722);color:#fff;padding:12px 14px;font-weight:600;display:flex;justify-content:space-between;align-items:center;}
#bhChat .bh-head span{cursor:pointer;font-size:20px;line-height:1;}
#bhLog{height:300px;overflow-y:auto;padding:12px;background:#f7f7f7;font-size:14px;}
.bh-msg{margin-bottom:10px;padding:9px 12px;border-radius:12px;max-width:85%;white-space:pre-wrap;word-wrap:break-word;line-height:1.4;}
.bh-user{background:#ff8c00;color:#fff;margin-left:auto;border-bottom-right-radius:4px;}
.bh-bot{background:#fff;color:#222;border:1px solid #e5e5e5;border-bottom-left-radius:4px;}
#bhChips{padding:8px 10px 0;display:flex;flex-wrap:wrap;gap:6px;background:#fff;}
#bhChips button{font-size:12px;padding:5px 9px;border-radius:14px;border:1px solid #ff8c00;background:#fff;color:#ff5722;cursor:pointer;}
#bhChat .bh-row{display:flex;padding:10px;background:#fff;gap:6px;}
#bhInput{flex:1;padding:10px;border:1px solid #ddd;border-radius:10px;outline:none;font-size:14px;color:#222;background:#fff;}
#bhSend{padding:0 14px;border:none;border-radius:10px;background:#ff8c00;color:#fff;cursor:pointer;font-size:14px;}
#bhSend:disabled{opacity:.5;cursor:default;}
</style>

<button id="bhChatBtn" title="Chat with our travel assistant">💬</button>

<div id="bhChat">
    <div class="bh-head">Travel Assistant ✈️ <span id="bhClose">×</span></div>
    <div id="bhLog"></div>
    <div id="bhChips">
        <button type="button">Which package is cheapest?</button>
        <button type="button">Plan a 3-day trip</button>
        <button type="button">How do I book?</button>
    </div>
    <div class="bh-row">
        <input id="bhInput" type="text" maxlength="500" placeholder="Ask about our trips...">
        <button id="bhSend" type="button">Send</button>
    </div>
</div>

<script>
(function(){
    var box   = document.getElementById("bhChat");
    var log   = document.getElementById("bhLog");
    var input = document.getElementById("bhInput");
    var send  = document.getElementById("bhSend");
    var history = [];
    var started = false;

    function add(text, who){
        var d = document.createElement("div");
        d.className = "bh-msg " + (who === "user" ? "bh-user" : "bh-bot");
        d.textContent = text;           // textContent keeps the chat safe from HTML injection
        log.appendChild(d);
        log.scrollTop = log.scrollHeight;
        return d;
    }

    function toggle(){
        var open = box.style.display === "flex";
        box.style.display = open ? "none" : "flex";
        if (!open && !started){
            started = true;
            add("Hi! I'm the BlueHorizon travel assistant. Ask me about our packages, prices or how to book.", "bot");
        }
        if (!open) input.focus();
    }

    async function ask(text){
        text = text.trim();
        if (!text) return;
        add(text, "user");
        input.value = "";
        send.disabled = true;
        var wait = add("Typing...", "bot");

        try{
            var res = await fetch("ai_chat.php", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({message: text, history: history})
            });
            var data = await res.json();
            wait.textContent = data.reply;
            history.push({role: "user",  text: text});
            history.push({role: "model", text: data.reply});
            history = history.slice(-8);
        }catch(e){
            wait.textContent = "Sorry, something went wrong. Please try again.";
        }
        send.disabled = false;
        log.scrollTop = log.scrollHeight;
    }

    document.getElementById("bhChatBtn").onclick = toggle;
    document.getElementById("bhClose").onclick = toggle;
    send.onclick = function(){ ask(input.value); };
    input.addEventListener("keydown", function(e){ if (e.key === "Enter") ask(input.value); });
    document.querySelectorAll("#bhChips button").forEach(function(b){
        b.onclick = function(){ ask(b.textContent); };
    });
})();
</script>
