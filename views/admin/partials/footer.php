    </main>
</div>

<script>
    // Global notification helper
    function notify(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `fixed bottom-4 right-4 px-6 py-3 rounded-xl shadow-2xl text-white transform translate-y-10 opacity-0 transition-all duration-300 z-[9999] flex items-center ${type === 'success' ? 'bg-emerald-500' : 'bg-red-500'}`;
        toast.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} mr-3"></i> ${message}`;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('translate-y-10', 'opacity-0');
        }, 100);
        
        setTimeout(() => {
            toast.classList.add('translate-y-10', 'opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Check for PHP success/error parameters and notify once
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) notify(urlParams.get('success'), 'success');
    if (urlParams.has('error')) notify(urlParams.get('error'), 'error');
</script>
</body>
</html>
