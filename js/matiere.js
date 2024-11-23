document.addEventListener("DOMContentLoaded", function() {
    fetch('../php/matiere.php')
        .then(response => response.json())
        .then(data => {
            if (data.section && data.subjects) {
                const container = document.getElementById('subject-container');
                data.subjects.forEach(subject => {
                    const img = document.createElement('img');
                    img.src = `../images/${subject}.png`;
                    img.alt = subject.charAt(0).toUpperCase() + subject.slice(1);
                    img.title = `${subject.charAt(0).toUpperCase() + subject.slice(1)} Subject`;
                    img.addEventListener('click', function() {
                        window.location.href = `cours.html?subject=${subject}`;
                    });
                    container.appendChild(img);
                });
            } else {
                console.error('No valid section or subjects found');
            }
        })
        .catch(error => {
            console.error('Error fetching section data:', error);
        });
});
