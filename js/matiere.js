document.addEventListener("DOMContentLoaded", () => {
  console.log('JavaScript Loaded');
  fetch('../php/matiere.php')
      .then(response => {
          console.log('Received Response:', response);

          if (!response.ok) {
              throw new Error("Failed to fetch subjects data");
          }
          return response.json();
      })
      .then(data => {
          console.log('Fetched Data:', data);

          const { section, subjects } = data;
          const tilesContainer = document.querySelector('.tiles');

          if (!subjects || subjects.length === 0) {
              console.log("No subjects found");
              tilesContainer.innerHTML = "<p>No subjects found</p>";
              return;
          }

          const subjectNames = {
              arb: "Arabic",
              fr: "French",
              eng: "English",
              philo: "Philosophy",
              mathinfo: "Math for Informatics",
              phyinfo: "Physics for Informatics",
              prog: "Programming",
              sti: "STI",
              sc:"Science",
              mathmath: "Advanced Math",
              phymath: "Physics for Math",
              mathmasc: "Math for Science",
              phymasc: "Physics for Science",
              arbl: "Arabic Literature",
              frl: "French Literature",
              engl: "English Literature",
              philol: "Philosophy Literature",
              eco: " Economics",
              matheco: " Math for Economics",
              infoeco: "Info for Economics ",
              mathtech: "Math for Technique ",
              phytech: "Physics for Technique ",
              info: "Informatics"
          };
          subjects.forEach((subject, index) => {
            const article = document.createElement('article');
            const styleClass = `style${(index % 6) + 1}`;
            console.log(`Index: ${index}, Subject: ${subject}, Assigned Class: ${styleClass}`);
            article.className = styleClass;
              const imageWrapper = document.createElement('span');
              imageWrapper.className = "image";

              const img = document.createElement('img');
              img.src = `../images/${subject}.png`;
              img.alt = subjectNames[subject] || subject;
              img.style.height = "100%"; 
              img.style.objectFit = "cover";
              imageWrapper.appendChild(img);

              const link = document.createElement('a');
              link.href = `cours.html?subject=${subject}`;
              const h2 = document.createElement('h2');
              h2.textContent = subjectNames[subject] || subject;

              const content = document.createElement('div');
              content.className = 'content';

              link.appendChild(h2);
              link.appendChild(content);

              article.appendChild(imageWrapper);
              article.appendChild(link);
              tilesContainer.appendChild(article);
          });
      })
      .catch(error => {
          console.error('Error loading subjects:', error);
          const tilesContainer = document.querySelector('.tiles');
          tilesContainer.innerHTML = `<p style="color: red;">Failed to load subjects. Please try again later.</p>`;
      });
});
