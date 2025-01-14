      // Snowflake characters (can be customized)
const snowflakeChars = ['❄', '✻', '✼', '❅', '❆', '✵'];

// Function to create a snowflake
function createSnowflake() {
  const snowflake = document.createElement('div');
  snowflake.classList.add('snowflake');
  
  // Randomly select a snowflake symbol
  snowflake.textContent = snowflakeChars[Math.floor(Math.random() * snowflakeChars.length)];
  
  // Set random properties for the snowflake
  const maxWidth = document.documentElement.clientWidth - 30; // 30px padding to keep snowflakes in view
  snowflake.style.left = `${Math.random() * maxWidth}px`; // Random horizontal position within the screen width
  snowflake.style.fontSize = `${Math.random() * 15 + 10}px`; // Random size from 10px to 25px
  snowflake.style.animationDuration = `${Math.random() * 5 + 3}s`; // Fall speed between 3s to 8s
  snowflake.style.animationDelay = `${Math.random() * 2}s`; // Random delay before the flake appears

  // Add the keyframe animation
  snowflake.style.animation = `fall ${Math.random() * 5 + 5}s linear infinite`;

  document.body.appendChild(snowflake);

  // Remove the snowflake from the DOM after it finishes falling
  setTimeout(() => {
    snowflake.remove();
  }, 10000); // Adjust this time to match the fall duration
}

// Generate snowflakes at an interval
setInterval(createSnowflake, 400); // Create a new snowflake every 300ms