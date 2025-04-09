// Modal Handling
const loginLink = document.getElementById('login-link')
const signupLink = document.getElementById('signup-link')
const loginModal = document.getElementById('login-modal')
const signupModal = document.getElementById('signup-modal')
const closes = document.getElementsByClassName('close')

loginLink.onclick = () => (loginModal.style.display = 'block')
signupLink.onclick = () => (signupModal.style.display = 'block')

for (let close of closes) {
  close.onclick = () => {
    loginModal.style.display = 'none'
    signupModal.style.display = 'none'
  }
}

window.onclick = (event) => {
  if (event.target == loginModal) loginModal.style.display = 'none'
  if (event.target == signupModal) signupModal.style.display = 'none'
}

// Login Form Submission
document.getElementById('login-form').onsubmit = async (e) => {
  e.preventDefault()
  const formData = new FormData(e.target)
  try {
    const response = await fetch('admin/login.php', {
      method: 'POST',
      body: formData,
    })
    const result = await response.json()
    alert(result.message)
    if (result.success) location.reload()
  } catch (error) {
    alert('An error occurred. Please try again.')
  }
}

// Signup Form Submission
document.getElementById('signup-form').onsubmit = async (e) => {
  e.preventDefault()
  const formData = new FormData(e.target)
  try {
    const response = await fetch('admin/signup.php', {
      method: 'POST',
      body: formData,
    })
    const result = await response.json()
    alert(result.message)
    if (result.success) signupModal.style.display = 'none'
  } catch (error) {
    alert('An error occurred. Please try again.')
  }
}

// Function to escape HTML to prevent XSS
function escapeHTML(str) {
  const div = document.createElement('div')
  div.textContent = str
  return div.innerHTML
}

// Search Functionality
const searchInput = document.querySelector('.search-bar input')
searchInput.oninput = async (e) => {
  const query = e.target.value
  try {
    const response = await fetch(
      `admin/search.php?query=${encodeURIComponent(query)}`
    )
    const products = await response.json()
    const productList = document.getElementById('product-list')
    productList.innerHTML = products
      .map(
        (p) => `
          <div class="product-item">
            <img src="${escapeHTML(p.image)}" alt="${escapeHTML(p.name)}">
            <h3>${escapeHTML(p.name)}</h3>
            <p>₱${escapeHTML(p.price.toString())}</p>
          </div>
        `
      )
      .join('')
  } catch (error) {
    console.error('Error fetching products:', error)
  }
}

// Carousel Functionality
const carouselInner = document.querySelector('.carousel-inner')
const carouselItems = document.querySelectorAll('.carousel-item')
const prevBtn = document.querySelector('.carousel-control.prev')
const nextBtn = document.querySelector('.carousel-control.next')
const dots = document.querySelectorAll('.dot')

let currentIndex = 0
const totalItems = carouselItems.length

if (totalItems !== dots.length) {
  console.warn(
    `Mismatch between carousel items (${totalItems}) and dots (${dots.length}). Please ensure they match.`
  )
}

function updateCarousel() {
  carouselInner.style.transform = `translateX(-${currentIndex * 100}%)`
  dots.forEach((dot, index) => {
    dot.classList.toggle('active', index === currentIndex)
  })
}

prevBtn.addEventListener('click', () => {
  currentIndex = (currentIndex - 1 + totalItems) % totalItems
  updateCarousel()
})

nextBtn.addEventListener('click', () => {
  currentIndex = (currentIndex + 1) % totalItems
  updateCarousel()
})

dots.forEach((dot, index) => {
  dot.addEventListener('click', () => {
    currentIndex = index
    updateCarousel()
  })
})

// Auto-slide every 5 seconds
setInterval(() => {
  currentIndex = (currentIndex + 1) % totalItems
  updateCarousel()
}, 5000)
