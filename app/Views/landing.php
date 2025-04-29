<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BeyondBlogs - Your Blogging Platform</title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/custom.css">
    <style>
        body { 
            background-color: #f8f9fa; 
            margin: 0; 
            overflow-x: hidden; 
        }
        .hero { 
            text-align: center; 
            padding: 100px 0; 
            position: relative; 
            z-index: 1; 
            background: rgba(0, 0, 0, 0.6); 
            color: white; 
        }
        .hero h1 { 
            font-size: 3.5rem; 
            font-weight: bold; 
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); 
        }
        .hero p { 
            font-size: 1.3rem; 
            margin-bottom: 20px; 
        }
        .btn-custom { 
            margin: 10px; 
            padding: 10px 20px; 
            font-size: 1.1rem; 
        }
        #three-canvas { 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            z-index: 0; 
        }
        .features { 
            padding: 50px 0; 
            background: #fff; 
        }
        .feature-box { 
            padding: 20px; 
            border-radius: 10px; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            transition: transform 0.3s; 
        }
        .feature-box:hover { 
            transform: translateY(-10px); 
        }
    </style>
</head>
<body>
    <canvas id="three-canvas"></canvas>
    <div class="hero">
        <div class="container">
            <h1>Welcome to BeyondBlogs</h1>
            <p>A modern blogging platform to share your stories with the world.</p>
            <p>Join now or explore our community of writers!</p>
            <a href="/register" class="btn btn-primary btn-custom">Register</a>
            <a href="/login" class="btn btn-secondary btn-custom">Log In</a>
            <a href="/posts" class="btn btn-success btn-custom">View Posts</a>
        </div>
    </div>
    <div class="features">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="feature-box">
                        <h3>Create</h3>
                        <p>Write and publish blog posts with our easy-to-use editor.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <h3>Share</h3>
                        <p>Showcase your posts to readers and authors alike.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <h3>Manage</h3>
                        <p>Edit or delete your posts from a secure admin panel.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/js/jquery-3.7.1.min.js"></script>
    <script src="/assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- <script src="/assets/threejs/three.min.js"></script> -->
    <script type="module">
        import * as THREE from '/assets/threejs/build/three.module.js'
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ canvas: document.getElementById('three-canvas'), alpha: true });
        renderer.setSize(window.innerWidth, window.innerHeight);

        // Particles
        const nodeCount = 80;
        const nodes = [];
        const nodeGeometry = new THREE.SphereGeometry(0.03, 32, 32);
        const vibrantColors = [0x00ffcc, 0xff00cc, 0x3300ff, 0xff3300, 0x00ff00];

        for (let i = 0; i < nodeCount; i++) {
            const material = new THREE.PointsMaterial({
                size: 0.15,
                color: vibrantColors[Math.floor(Math.random() * vibrantColors.length)],
                transparent: true,
                opacity: 0.9,
                blending: THREE.AdditiveBlending
            });
            const node = new THREE.Points(nodeGeometry, material);
            node.position.set(
                (Math.random() - 0.5) * 20,
                (Math.random() - 0.5) * 20,
                (Math.random() - 0.5) * 20
            );
            node.velocity = new THREE.Vector3(
                (Math.random() - 0.5) * 0.02,
                (Math.random() - 0.5) * 0.02,
                (Math.random() - 0.5) * 0.02
            );
            node.basePosition = node.position.clone();
            scene.add(node);
            nodes.push(node);
        }

        camera.position.z = 15;

        // Mouse Interaction
        let isMousePressed = false;
        let mousePos = new THREE.Vector3();
        const mouse = new THREE.Vector2();

        document.addEventListener('mousedown', (event) => {
            if (event.button === 0) {
                isMousePressed = true;
                updateMousePosition(event);
            }
        });

        document.addEventListener('mouseup', () => {
            isMousePressed = false;
        });

        document.addEventListener('mousemove', (event) => {
            updateMousePosition(event);
        });

        function updateMousePosition(event) {
            mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
            mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
            const vector = new THREE.Vector3(mouse.x, mouse.y, 0.5);
            vector.unproject(camera);
            const dir = vector.sub(camera.position).normalize();
            const distance = -camera.position.z / dir.z;
            mousePos = camera.position.clone().add(dir.multiplyScalar(distance));
        }

        function animate() {
            requestAnimationFrame(animate);
            nodes.forEach(node => {
                if (isMousePressed) {
                    const direction = mousePos.clone().sub(node.position).normalize().multiplyScalar(0.1);
                    node.position.add(direction);
                    node.velocity.set(0, 0, 0); // Reset velocity during attraction
                } else {
                    const distanceToBase = node.position.distanceTo(node.basePosition);
                    if (distanceToBase > 0.05) { // Only move if not close to base
                        const direction = node.basePosition.clone().sub(node.position).normalize().multiplyScalar(0.1);
                        node.position.add(direction);
                        node.position.add(node.velocity);
                        node.velocity.multiplyScalar(0);
                    } else {
                        // Snap to base position and stop velocity to prevent shaking
                        node.position.copy(node.basePosition);
                        node.velocity.set(0, 0, 0);
                    }
                }
            });
            renderer.render(scene, camera);
        }
        animate();

        // Resize Handler
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        // Cleanup on page unload
        window.addEventListener('unload', () => {
            nodes.forEach(node => {
                scene.remove(node);
                node.geometry.dispose();
                node.material.dispose();
            });
            renderer.dispose();
        });
    </script>
</body>
</html>