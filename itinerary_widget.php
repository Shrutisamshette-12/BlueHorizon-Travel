<?php
// itinerary_widget.php: "AI Trip Planner" card for a destination page.
// The destination comes from the page's own file name (goa.php -> Goa, Kashmir.php -> Kashmir).
$aiPlace = ucfirst(strtolower(basename($_SERVER['SCRIPT_NAME'], '.php')));
?>
<style>
.ai-plan{
    background:#fff;
    padding:25px;
    border-radius:15px;
    margin-top:20px;
    margin-bottom:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}
.ai-plan h2{margin-bottom:6px;}
.ai-plan .ai-sub{color:#777;font-size:14px;margin-bottom:15px;}
.ai-row{display:flex;gap:10px;flex-wrap:wrap;align-items:center;}
.ai-row select{
    padding:10px 12px;border:1px solid #ddd;border-radius:10px;
    font-size:14px;background:#fff;color:#222;outline:none;
}
.ai-row button{
    padding:10px 18px;border:none;border-radius:10px;cursor:pointer;
    background:linear-gradient(135deg,#ff8c00,#ff5722);color:#fff;font-size:14px;font-weight:600;
}
.ai-row button:disabled{opacity:.6;cursor:default;}
#aiPlanOut{
    margin-top:16px;padding:16px;border-radius:12px;background:#fff7ec;
    white-space:pre-wrap;line-height:1.6;font-size:14px;color:#333;display:none;
}
</style>

<div class="ai-plan">
    <h2>✨ AI Trip Planner</h2>
    <p class="ai-sub">Get a day-by-day plan for <?php echo htmlspecialchars($aiPlace); ?>, made by AI in a few seconds.</p>

    <div class="ai-row">
        <select id="aiDays">
            <option value="1">1 day</option>
            <option value="2">2 days</option>
            <option value="3" selected>3 days</option>
            <option value="4">4 days</option>
            <option value="5">5 days</option>
            <option value="6">6 days</option>
            <option value="7">7 days</option>
        </select>

        <select id="aiStyle">
            <option value="Comfortable">Comfortable</option>
            <option value="Budget">Budget</option>
            <option value="Adventure">Adventure</option>
            <option value="Family">Family</option>
            <option value="Romantic">Romantic</option>
        </select>

        <button type="button" id="aiPlanBtn">Plan my trip</button>
    </div>

    <div id="aiPlanOut"></div>
</div>

<script>
(function(){
    var btn = document.getElementById("aiPlanBtn");
    var out = document.getElementById("aiPlanOut");

    btn.onclick = async function(){
        btn.disabled = true;
        btn.textContent = "Planning...";
        out.style.display = "block";
        out.textContent = "Creating your itinerary...";

        try{
            var res = await fetch("ai_itinerary.php", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: JSON.stringify({
                    place: <?php echo json_encode($aiPlace); ?>,
                    days:  document.getElementById("aiDays").value,
                    style: document.getElementById("aiStyle").value
                })
            });
            var data = await res.json();
            out.textContent = data.plan;     // textContent keeps the page safe from HTML injection
        }catch(e){
            out.textContent = "Sorry, something went wrong. Please try again.";
        }

        btn.disabled = false;
        btn.textContent = "Plan my trip";
    };
})();
</script>
