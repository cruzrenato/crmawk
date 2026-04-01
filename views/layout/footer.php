    </main>

    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const body = document.body;
        const icon = themeToggle ? themeToggle.querySelector('i') : null;

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const currentTheme = body.getAttribute('data-theme');
                const newTheme = currentTheme === 'escuro' ? 'claro' : 'escuro';
                
                body.setAttribute('data-theme', newTheme);
                icon.className = newTheme === 'escuro' ? 'fas fa-moon' : 'fas fa-sun';
                
                // Salvar preferência via AJAX se necessário
                // fetch('api/settings/theme', { method: 'POST', body: JSON.stringify({ theme: newTheme }) });
            });
        }
    </script>
</body>
</html>
