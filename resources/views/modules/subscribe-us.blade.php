<style>
.slimza-newsletter-wrap{
  
    width:100%;
    background:url('{{ asset("images/home/newsletter-bg.png") }}') center/cover no-repeat;
    position:relative;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* dark overlay */
.slimza-newsletter-wrap::before{
    content:"";
    position:absolute;
    inset:0;
    background:rgba(0,0,0,0.88);
}

/* content wrapper */
.slimza-newsletter-box{
    position:relative;
    z-index:2;
    text-align:center;
    width:100%;
    max-width:520px;
    padding:20px;
}

/* title */
.slimza-newsletter-title{
    color:#fff;
    font-size:26px;
    font-weight:600;
    margin-bottom:10px;
}

/* subtitle */
.slimza-newsletter-text{
    color:rgba(255,255,255,0.75);
    font-size:14px;
    margin-bottom:25px;
}

/* form */
.slimza-newsletter-form{
    display:flex;
    flex-direction:column;
    gap:12px;
    align-items:center;
}

/* input */
.slimza-newsletter-input{
    width:100%;
    max-width:420px;
    padding:14px;
    background:transparent;
    border:none;
    border-bottom:1px solid rgba(255,255,255,0.3);
    color:#fff;
    outline:none;
}

.slimza-newsletter-input::placeholder{
    color:rgba(255,255,255,0.5);
}

.slimza-newsletter-input:focus{
    border-bottom:1px solid #9eef0b;
}

/* button */
.slimza-newsletter-btn{
    padding:12px 28px;
    border:1px solid #9eef0b;
    background:transparent;
    color:#9eef0b;
    cursor:pointer;
    transition:0.3s;
}

.slimza-newsletter-btn:hover{
    background:#9eef0b;
    color:#000;
}

/* security text */
.slimza-newsletter-secure{
    margin-top:18px;
    font-size:12px;
    color:rgba(255,255,255,0.6);
}

.slimza-newsletter-secure span{
    color:#9eef0b;
    font-weight:600;
}
</style>

<div class="slimza-newsletter-wrap">

    <div class="slimza-newsletter-box">

        <div class="slimza-newsletter-title">
        <h2>Get First Access to the Best Deals, Gossip & Offers</h2>   
        </div>

        <div class="slimza-newsletter-text">
            Enter your email to stay updated with exclusive offers.
        </div>

        <form id="slimzaNewsletterForm" class="slimza-newsletter-form">

            <input 
                type="email"
                id="slimza_email"
                class="slimza-newsletter-input"
                placeholder="Enter Your Email"
                required
            >

            <button type="submit" class="slimza-newsletter-btn">
                Send
            </button>

        </form>

        <div class="slimza-newsletter-secure">
            YOUR INFORMATION IS <span>SECURE</span> WITH US
        </div>

    </div>

</div>

<script>
document.getElementById("slimzaNewsletterForm").addEventListener("submit", async function(e){
    e.preventDefault();

    const email = document.getElementById("slimza_email").value;

    const res = await fetch("/signup-user", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ email })
    });

    const data = await res.json();
    alert(data.message || "Success");
});
</script>