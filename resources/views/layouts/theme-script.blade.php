<script>
    (() => {
        const persisted = localStorage.getItem('theme');
        const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        const isDark = persisted === 'dark' || (!persisted && systemDark);
        document.documentElement.classList.toggle('dark', isDark);
    })();
</script>
