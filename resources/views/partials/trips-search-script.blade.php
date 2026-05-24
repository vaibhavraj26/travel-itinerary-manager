<script>
    (function(){
        function showLoading(show) {
            const loading = document.getElementById('trips-grid-loading');
            const container = document.getElementById('trips-grid-container');

            if (loading) {
                loading.classList.toggle('hidden', !show);
            }
            if (container) {
                container.classList.toggle('opacity-50', show);
                container.classList.toggle('pointer-events-none', show);
            }
        }

        function fetchAndReplace(url, container) {
            showLoading(true);
            return fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            }).then(function(resp){
                return resp.json();
            }).then(function(data){
                if (data && data.html !== undefined) {
                    if (container) container.innerHTML = data.html;
                    return true;
                }
                return false;
            }).finally(function(){
                showLoading(false);
            });
        }

        window.tripsSubmitForm = function(f) {
            try {
                const existing = new URLSearchParams(window.location.search);
                const formParams = new URLSearchParams(new FormData(f));
                formParams.forEach((v, k) => {
                    if (v !== '') existing.set(k, v);
                    else existing.delete(k);
                });
                const q = existing.toString();
                const url = f.action + (q ? ('?' + q) : '');

                const container = document.getElementById('trips-grid-container');
                fetchAndReplace(url, container).then(function(success){
                    if (success) {
                        history.pushState(null, '', url);
                    } else {
                        window.location.href = url;
                    }
                }).catch(function(err){
                    console.error('Search error', err);
                    window.location.href = url;
                });
            } catch (e) {
                const params = new URLSearchParams(new FormData(f)).toString();
                window.location.href = f.action + (params ? ('?' + params) : '');
            }
        };

        // Handle browser navigation (back/forward)
        window.addEventListener('popstate', function(event){
            const url = window.location.href;
            const container = document.getElementById('trips-grid-container');
            fetchAndReplace(url, container).catch(function(err){
                console.error('Popstate fetch error', err);
            });
        });
    })();
</script>
