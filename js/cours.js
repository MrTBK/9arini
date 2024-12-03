document.addEventListener("DOMContentLoaded", () => {
    // Get the subject from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const subject = urlParams.get("subject");

    if (!subject) {
        document.querySelector(".tiles").innerHTML = "<p>Subject not specified.</p>";
        return;
    }

    // Fetch courses for the given subject from PHP
    fetch(`../php/cours.php?subject=${subject}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            const { courses } = data;
            const coursesContainer = document.querySelector(".tiles");

            if (!courses || courses.length === 0) {
                coursesContainer.innerHTML = "<p>No courses available for this subject.</p>";
                return;
            }

            // Render courses as articles (styling as individual boxes)
            courses.forEach((course, index) => {
                const article = document.createElement('article');
                const styleClass = `style${(index % 6) + 1}`; // Cycle between 6 styles
                console.log(`Index: ${index}, Course: ${course.title}, Assigned Class: ${styleClass}`);
                article.className = styleClass;

                // Image Wrapper with the shared image
                const imageWrapper = document.createElement('span');
                imageWrapper.className = "image";

                const img = document.createElement('img');
                img.src = `../images/${subject}.png`; // Use the shared image based on subject
                img.alt = course.title;
                img.style.height = "100%";
                img.style.objectFit = "cover";
                imageWrapper.appendChild(img);

                // Course Title
                const link = document.createElement('a');
                const h2 = document.createElement('h2');
                h2.textContent = course.title;

                const content = document.createElement('div');
                content.className = 'content';

                // Combine elements
                link.appendChild(h2);
                article.appendChild(imageWrapper);
                article.appendChild(content);
                article.appendChild(link);

                // Add click event to open popup
                article.addEventListener("click", () => showPopup(course)); // Pass course to showPopup

                // Append article to the container
                coursesContainer.appendChild(article);
            });
        })
        .catch(error => {
            console.error("Error fetching courses:", error);
            document.querySelector(".tiles").innerHTML = "<p>Failed to load courses. Please try again later.</p>";
        });
});

function showPopup(course) {
    const popup = document.querySelector(".popup");
    const popupContent = document.querySelector(".popup-content");

    popupContent.innerHTML = `
        <h2>${course.title}</h2>
        <p>Price: 5 DT</p>
        <button onclick="purchaseCourse('${course.title}')">Buy Now</button>
        <button onclick="closePopup()">Close</button>
    `;

    popup.style.display = "flex";
}

// Function to close the popup
function closePopup() {
    document.querySelector(".popup").style.display = "none";
}
function purchaseCourse(courseId) {
    alert(`Cour : ${courseId} ajouter a la bibleoteque !`);
    closePopup();
}
