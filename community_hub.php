<?php 
session_start(); 
include 'includes/header.php'; 
?>

<style>
    /* General Styles */
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #2E8B57, #228B22);
        margin: 0;
        padding: 0;
        text-align: center;
        color: white;
        position: relative;
        overflow-x: hidden;
    }

    /* New Side Elements - Animated Plant Growth */
    .side-container {
        position: fixed;
        top: 0;
        height: 100%;
        width: 15%;
        z-index: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        pointer-events: none;
        overflow: hidden;
    }

    .left-side {
        left: 0;
    }

    .right-side {
        right: 0;
    }

    /* Plant Growth Animation */
    .plant-container {
        position: absolute;
        bottom: 0;
        width: 100%;
        height: 100%;
    }

    .plant-stem {
        position: absolute;
        bottom: 0;
        width: 6px;
        background: linear-gradient(to top, #3a6a47, #8bc34a);
        border-radius: 3px;
        transform-origin: bottom center;
        animation: growPlant 15s ease-out forwards;
    }

    .plant-leaf {
        position: absolute;
        width: 30px;
        height: 15px;
        background: linear-gradient(to bottom right, #8bc34a, #4caf50);
        border-radius: 50% 50% 50% 0;
        transform-origin: bottom left;
        opacity: 0;
        animation: growLeaf 3s ease-out forwards;
    }

    .plant-flower {
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: radial-gradient(circle, #ffffff, #f1c40f);
        transform: scale(0);
        opacity: 0;
        animation: bloomFlower 4s ease-out forwards;
    }

    @keyframes growPlant {
        0% { height: 0; }
        100% { height: 80%; }
    }

    @keyframes growLeaf {
        0% { transform: scale(0) rotate(-10deg); opacity: 0; }
        100% { transform: scale(1) rotate(-10deg); opacity: 1; }
    }

    @keyframes bloomFlower {
        0% { transform: scale(0); opacity: 0; }
        70% { transform: scale(1.2); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }

    /* Particle Ecosystem Animation */
    .particle-container {
        position: absolute;
        top: 0;
        width: 100%;
        height: 100%;
    }

    .particle {
        position: absolute;
        border-radius: 50%;
        opacity: 0.6;
        filter: blur(1px);
        animation: floatParticle 20s infinite linear;
    }

    .particle.water {
        background-color: #3498db;
    }

    .particle.earth {
        background-color: #8B4513;
    }

    .particle.air {
        background-color: #ffffff;
    }

    .particle-line {
        position: absolute;
        height: 1px;
        background: rgba(255, 255, 255, 0.2);
        transform-origin: left center;
        opacity: 0;
        transition: opacity 0.5s ease;
    }

    @keyframes floatParticle {
        0% { transform: translate(0, 0); }
        25% { transform: translate(30%, 20%); }
        50% { transform: translate(10%, 40%); }
        75% { transform: translate(-20%, 20%); }
        100% { transform: translate(0, 0); }
    }

    /* Fun Facts Box in Bottom Left */
    .fun-facts-container {
        position: fixed;
        bottom: 20px;
        left: 20px;
        background: rgba(0, 0, 0, 0.6);
        border-radius: 10px;
        padding: 15px;
        max-width: 300px;
        text-align: left;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        border-left: 4px solid #4CAF50;
        z-index: 10;
        backdrop-filter: blur(5px);
        transition: opacity 0.5s ease;
    }

    .fun-facts-title {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        color: #4CAF50;
        font-weight: bold;
    }

    .fun-facts-title i {
        margin-right: 8px;
    }

    .fun-fact {
        font-size: 14px;
        line-height: 1.4;
        display: none;
        animation: fadeFact 20s linear infinite;
    }

    .fun-fact.active {
        display: block;
    }

    @keyframes fadeFact {
        0%, 100% { opacity: 0; }
        10%, 90% { opacity: 1; }
    }

    /* Progress bar for fact timing */
    .fact-progress {
        margin-top: 10px;
        width: 100%;
        height: 3px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
        overflow: hidden;
    }

    .fact-progress-bar {
        width: 0%;
        height: 100%;
        background: #4CAF50;
        animation: progressBar 20s linear infinite;
    }

    @keyframes progressBar {
        0% { width: 0%; }
        100% { width: 100%; }
    }

    /* Hub container styles */
    .hub-container {
        max-width: 1000px;
        margin: auto;
        padding: 20px;
        position: relative;
        z-index: 1;
    }

    /* Improved Engaging Heading */
    .hub-title {
        font-size: 42px;
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.5);
        background: linear-gradient(45deg, #ffffff, #4CAF50, #ffffff);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        position: relative;
        display: inline-block;
        padding: 0 10px;
        animation: titleGlow 3s infinite alternate;
    }

    @keyframes titleGlow {
        0% { text-shadow: 0 0 10px rgba(76, 175, 80, 0.5); }
        100% { text-shadow: 0 0 20px rgba(76, 175, 80, 0.9), 0 0 30px rgba(255, 255, 255, 0.7); }
    }

    .hub-title::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: linear-gradient(90deg, transparent, #ffffff, transparent);
        border-radius: 3px;
    }

    /* Fixed Search Bar */
    .search-container {
        width: 100%;
        max-width: 500px;
        height: 60px;
        margin: 0 auto 20px auto;
        position: relative;
    }

    .search-bar {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 20px;
        font-size: 16px;
        text-align: center;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        position: absolute;
        top: 0;
        left: 0;
    }

    /* Cards Layout */
    .cards-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
    min-height: 300px; /* Ensure container doesn't collapse */
    margin-top: 20px; /* Add margin to separate from search bar */
}

    .card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        padding: 20px;
        width: 250px;
        height: 250px;
        text-align: center;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        cursor: pointer;
        position: relative;
        color: black;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
    }

    .card i {
        font-size: 50px;
        color: #2ECC71;
        margin-bottom: 10px;
    }

    .card h3 {
        font-size: 20px;
        margin-bottom: 10px;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.9);
        width: 60%;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        padding: 20px;
        z-index: 1000;
        text-align: left;
        max-height: 80vh;
        overflow-y: auto;
        opacity: 0;
        transition: all 0.3s ease-in-out;
        color: black;
    }

    .modal.show {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
        display: block;
    }

    .modal h3 {
        margin-top: 0;
    }

    .modal-content {
        padding: 10px;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        background: #ff4d4d;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 5px;
        transition: 0.3s ease-in-out;
    }

    .close-btn:hover {
        background: #cc0000;
    }

    /* Overlay Background */
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .overlay.show {
        display: block;
    }
</style>

<!-- Left side decorative elements -->
<div class="side-container left-side">
    <!-- Plant Growth Animation -->
    <div class="plant-container" id="leftPlants"></div>
    
    <!-- Particle Ecosystem -->
    <div class="particle-container" id="leftParticles"></div>
</div>

<!-- Right side decorative elements -->
<div class="side-container right-side">
    <!-- Plant Growth Animation -->
    <div class="plant-container" id="rightPlants"></div>
    
    <!-- Particle Ecosystem -->
    <div class="particle-container" id="rightParticles"></div>
</div>

<!-- Fun Facts Container -->
<div class="fun-facts-container">
    <div class="fun-facts-title">
        <i class="fas fa-lightbulb"></i> Did You Know?
    </div>
    <div class="fun-fact active">The average American throws away about 4.5 pounds of waste every day, totaling 1,642 pounds per person annually.</div>
    <div class="fun-fact">Recycling one aluminum can saves enough energy to power a TV for three hours.</div>
    <div class="fun-fact">If all newspaper was recycled, we could save about 250 million trees each year.</div>
    <div class="fun-fact">Plastics can take up to 1,000 years to decompose in landfills.</div>
    <div class="fun-fact">Glass bottles take 4,000 years to decompose, but can be recycled indefinitely without losing quality.</div>
    <div class="fun-fact">The Great Pacific Garbage Patch is a collection of marine debris estimated to be twice the size of Texas.</div>
    <div class="fun-fact">Composting food waste reduces methane emissions from landfills and creates nutrient-rich soil.</div>
    <div class="fun-fact">E-waste represents only 2% of trash in landfills but accounts for 70% of toxic waste.</div>
    <div class="fun-fact">The energy saved from recycling one glass bottle can power a computer for 25 minutes.</div>
    <div class="fun-fact">Americans throw away enough office paper each year to build a 12-foot-high wall from Los Angeles to New York City.</div>
    <div class="fact-progress">
        <div class="fact-progress-bar"></div>
    </div>
</div>

<div class="hub-container">
    <h2 class="hub-title">Community Hub</h2>

    <!-- Search Bar in Fixed Container -->
    <div class="search-container">
        <input type="text" id="search" class="search-bar" placeholder="🔍 Search sections..." onkeyup="filterCards()">
    </div>

    <div class="cards-container">
        <div class="card" data-name="education" onclick="openModal('education')">
            <i class="fas fa-book"></i>
            <h3>Waste Management 📚</h3>
        </div>
        <div class="card" data-name="recycling" onclick="openModal('recycling')">
            <i class="fas fa-recycle"></i>
            <h3>Recycling & Upcycling 🔄</h3>
        </div>
        <div class="card" data-name="gamification" onclick="openModal('gamification')">
            <i class="fas fa-gamepad"></i>
            <h3>Gamification & Challenges 🎯</h3>
        </div>
        <div class="card" data-name="news" onclick="openModal('news')">
            <i class="fas fa-newspaper"></i>
            <h3>News & Awareness Hub 📰</h3>
        </div>
        <div class="card" data-name="community" onclick="openModal('community')">
            <i class="fas fa-exclamation-triangle"></i>
            <h3>Community Interaction ⚠️</h3>
        </div>
        <div class="card" data-name="media" onclick="openModal('media')">
            <i class="fas fa-photo-video"></i>
            <h3>Fun & Engaging Media 🎥</h3>
        </div>
    </div>
</div>

<!-- Overlay Background -->
<div class="overlay" id="overlay" onclick="closeModal()"></div>

<!-- Modals -->
<div class="modal" id="education">
    <button class="close-btn" onclick="closeModal()">✖</button>
    <h3>Waste Management Education 📚</h3>
    
    <!-- Image -->
    <div style="display: flex; justify-content: center; margin-bottom: 15px;">
    <img src="assets/waste-management.jpg" alt="Waste Management" style="width: 10%; border-radius: 100px;">
</div>

    
    <!-- Introduction -->
    <p>Proper waste management is essential for environmental sustainability. Understanding different waste types and how to handle them can help reduce pollution and improve our ecosystem.</p>

    <!-- Video -->
    <iframe width="100%" height="250px" style="border-radius: 10px;"
        src="https://www.youtube.com/embed/OasbYWF4_S8" 
        title="Waste Segregation" frameborder="0" allowfullscreen>
    </iframe>

    <!-- Sections -->
    <h4>🔹 Types of Waste</h4>
    <ul>
        <li><b>Biodegradable:</b> Organic waste like food scraps and garden waste.</li>
        <li><b>Non-Biodegradable:</b> Plastics, metals, and glass that take longer to decompose.</li>
        <li><b>Hazardous Waste:</b> Chemicals, batteries, and medical waste requiring special disposal.</li>
    </ul>

    <h4>🔹 Waste Segregation Tips</h4>
    <ul>
        <li>Use **separate bins** for biodegradable and non-biodegradable waste.</li>
        <li>Reduce, Reuse, and Recycle whenever possible.</li>
        <li>Avoid using single-use plastics.</li>
    </ul>

    <h4>🔹 Benefits of Proper Waste Management</h4>
    <p>✅ Reduces pollution and protects natural resources.</p>
    <p>✅ Helps in composting organic waste for soil enrichment.</p>
    <p>✅ Minimizes landfill waste and improves community cleanliness.</p>

    <p style="text-align: center; margin-top: 15px;">
        <b>🌍 Small actions lead to a big impact! Start segregating your waste today. ♻</b>
    </p>
</div>


<div class="modal" id="recycling">
    <button class="close-btn" onclick="closeModal()">✖</button>
    <h3>Recycling & Upcycling Tips 🔄</h3>
    <p>Innovative ways to repurpose items and reduce landfill waste.</p>
</div>

<div class="modal" id="gamification">
    <button class="close-btn" onclick="closeModal()">✖</button>
    <h3>Gamification & Challenges 🎯</h3>
    <p>Participate in interactive quizzes, earn points, and challenge your friends!</p>
</div>

<div class="modal" id="news">
    <button class="close-btn" onclick="closeModal()">✖</button>
    <h3>News & Awareness Hub 📰</h3>
    <p>Stay updated on environmental news and global sustainability efforts.</p>
</div>

<div class="modal" id="community">
    <button class="close-btn" onclick="closeModal()">✖</button>
    <h3>Community Interaction ⚠️</h3>
    <p>Collaborate with the community.</p>
</div>

<div class="modal" id="media">
    <button class="close-btn" onclick="closeModal()">✖</button>
    <h3>Fun & Engaging Media 🎥</h3>
    <p>Enjoy videos, images, and interactive media about waste management.</p>
</div>

<script>
    // Modal Functions
    function openModal(id) {
        document.getElementById(id).classList.add("show");
        document.getElementById("overlay").classList.add("show");
    }

    function closeModal() {
        document.querySelectorAll('.modal').forEach(modal => modal.classList.remove("show"));
        document.getElementById("overlay").classList.remove("show");
    }

    function filterCards() {
    let input = document.getElementById("search").value.toLowerCase();
    let cards = document.querySelectorAll(".card");

    cards.forEach(card => {
        let name = card.dataset.name.toLowerCase();
        if (name.includes(input)) {
            card.style.display = "block"; // Show matching cards
        } else {
            card.style.display = "none"; // Hide non-matching cards
        }
    });
}
    // Create Animated Plant Growth
    function createPlants(containerId, plantsCount) {
        const container = document.getElementById(containerId);
        
        for (let i = 0; i < plantsCount; i++) {
            // Create stem
            const stem = document.createElement('div');
            stem.className = 'plant-stem';
            
            // Random positioning and delays
            const leftPos = 10 + Math.random() * 80; // % within container
            stem.style.left = leftPos + '%';
            stem.style.animationDelay = (Math.random() * 5) + 's';
            
            // Add stem to container
            container.appendChild(stem);
            
            // Create leaves at different heights
            const leafCount = 2 + Math.floor(Math.random() * 4); // 2-5 leaves
            for (let j = 0; j < leafCount; j++) {
                const leaf = document.createElement('div');
                leaf.className = 'plant-leaf';
                
                // Position leaf on stem at different heights
                const leafHeight = 20 + (j * 20); // % of stem height
                leaf.style.bottom = leafHeight + '%';
                leaf.style.left = '100%'; // Attach to right side of stem
                
                // Alternate sides for leaves
                if (j % 2 === 0) {
                    leaf.style.left = '-100%';
                    leaf.style.transform = 'rotate(10deg)';
                    leaf.style.borderRadius = '50% 50% 0 50%';
                }
                
                // Random delays for growth
                leaf.style.animationDelay = (stem.style.animationDelay.replace('s', '') * 1 + 1 + j) + 's';
                
                stem.appendChild(leaf);
            }
            
            // Add flower at top for some plants
            if (Math.random() > 0.5) {
                const flower = document.createElement('div');
                flower.className = 'plant-flower';
                flower.style.top = '-10px';
                flower.style.left = '-7px';
                flower.style.animationDelay = (stem.style.animationDelay.replace('s', '') * 1 + 5) + 's';
                
                // Random flower colors
                const colors = ['#f1c40f', '#e74c3c', '#9b59b6', '#3498db', '#1abc9c'];
                const randomColor = colors[Math.floor(Math.random() * colors.length)];
                flower.style.background = `radial-gradient(circle, #ffffff, ${randomColor})`;
                
                stem.appendChild(flower);
            }
        }
    }
    
    // Create Particle Ecosystem
    function createParticles(containerId, particleCount) {
        const container = document.getElementById(containerId);
        const types = ['water', 'earth', 'air'];
        const particles = [];
        
        // Create particles
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle ' + types[Math.floor(Math.random() * types.length)];
            
            // Random size (2-6px)
            const size = 2 + (Math.random() * 4);
            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            
            // Random position
            const left = Math.random() * 100;
            const top = Math.random() * 100;
            particle.style.left = left + '%';
            particle.style.top = top + '%';
            
            // Random animation duration and delay
            const duration = 15 + (Math.random() * 10);
            const delay = Math.random() * 10;
            particle.style.animationDuration = duration + 's';
            particle.style.animationDelay = delay + 's';
            
            container.appendChild(particle);
            particles.push({
                element: particle,
                left: left,
                top: top
            });
        }
        
        // Create connections between nearby particles
        function updateConnections() {
            // Remove existing connections
            container.querySelectorAll('.particle-line').forEach(line => line.remove());
            
            // Check distances and create connections
            for (let i = 0; i < particles.length; i++) {
                const p1 = particles[i];
                const rect1 = p1.element.getBoundingClientRect();
                
                for (let j = i + 1; j < particles.length; j++) {
                    const p2 = particles[j];
                    const rect2 = p2.element.getBoundingClientRect();
                    
                    // Calculate distance
                    const dx = rect2.left - rect1.left;
                    const dy = rect2.top - rect1.top;
                    const distance = Math.sqrt(dx * dx + dy * dy);
                    
                    // If particles are close, create a connection
                    if (distance < 100) {
                        const line = document.createElement('div');
                        line.className = 'particle-line';
                        
                        // Position and rotate line to connect particles
                        line.style.width = distance + 'px';
                        line.style.left = rect1.left + 'px';
                        line.style.top = (rect1.top + rect1.height/2) + 'px';
                        
                        // Calculate angle
                        const angle = Math.atan2(dy, dx) * 180 / Math.PI;
                        line.style.transform = `rotate(${angle}deg)`;
                        
                        // Opacity based on distance
                        const opacity = 1 - (distance / 100);
                        line.style.opacity = opacity;
                        
                        container.appendChild(line);
                    }
                }
            }
            
            requestAnimationFrame(updateConnections);
        }
        
        // Initialize connection updates
        updateConnections();
        
        // Interactive particle behavior
        document.addEventListener('mousemove', function(event) {
            // Adjust particles on mousemove
            const mouseX = event.clientX;
            const mouseY = event.clientY;
            
            particles.forEach(p => {
                const rect = p.element.getBoundingClientRect();
                const dx = mouseX - rect.left;
                const dy = mouseY - rect.top;
                const distance = Math.sqrt(dx * dx + dy * dy);
                
                if (distance < 150) {
                    // Move away from cursor slightly
                    const factor = 1 - (distance / 150);
                    const moveX = dx * factor * 0.1;
                    const moveY = dy * factor * 0.1;
                    
                    const newLeft = parseFloat(p.element.style.left) - moveX;
                    const newTop = parseFloat(p.element.style.top) - moveY;
                    
                    p.element.style.left = newLeft + '%';
                    p.element.style.top = newTop + '%';
                }
            });
        });
    }
    
    // Initialize all animations
    window.addEventListener('DOMContentLoaded', (event) => {
        // Create plants on both sides
        createPlants('leftPlants', 5);
        createPlants('rightPlants', 5);
        
        // Create particle ecosystems
        createParticles('leftParticles', 20);
        createParticles('rightParticles', 20);
        
        // Start rotating facts
        rotateFacts();
    });

    // Rotating fun facts functionality
    function rotateFacts() {
        const facts = document.querySelectorAll('.fun-fact');
        let currentIndex = 0;
        
        setInterval(() => {
            facts.forEach((fact, index) => {
                fact.classList.remove('active');
            });
            
            currentIndex = (currentIndex + 1) % facts.length;
            facts[currentIndex].classList.add('active');
            
            // Reset animation for progress bar
            const progressBar = document.querySelector('.fact-progress-bar');
            progressBar.style.animation = 'none';
            progressBar.offsetHeight; // Trigger reflow
            progressBar.style.animation = 'progressBar 20s linear infinite';
        }, 20000); // 20 seconds
    }

    // Existing function for card filtering
    function filterCards() {
        let input = document.getElementById("search").value.toLowerCase();
        let cards = document.querySelectorAll(".card");

        cards.forEach(card => {
            let name = card.dataset.name.toLowerCase();
            if (name.includes(input)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    }
</script>

<?php include 'includes/footer.php'; ?>