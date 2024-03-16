<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle View</title>
    <style>
        .hide {
            display: none;
        }

        .tabs button {
            display: inline-block;
            padding: 10px 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 0 5px;
            background-color: #fff;
            cursor: pointer;
            transition: 0.3s;
            text-align: center;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        }

        .tabs button:hover {
            background-color: #ddd;
        }

        .tabs button.active {
            background-color: #000;
            color: #fff;
        }

        .tabs button:last-child {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            border-right: 10px solid #000;
        }
    </style>
</head>

<body>
    <button id="singleViewBtn">Tampilan 1</button>
    <button id="multiViewBtn">Per Bagian</button>

    <div id="tabs-container">
        <ul id="tabs"></ul>
        <div id="tab-content"></div>
    </div>

    <div class="dif1">Konten 1</div>
    <div class="dif2">Konten 2</div>
    <div class="dif3">Konten 3</div>
    <div class="dif4">Konten 4</div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const singleViewBtn = document.getElementById('singleViewBtn');
            const multiViewBtn = document.getElementById('multiViewBtn');

            const divs = document.querySelectorAll('div[class^="dif"]');

            // Fungsi untuk menyimpan preferensi pengguna
            function savePreference(viewType) {
                localStorage.setItem('viewPreference', viewType);
            }

            // Fungsi untuk memuat preferensi pengguna yang tersimpan
            function loadPreference() {
                const preference = localStorage.getItem('viewPreference');
                if (preference) {
                    showView(preference);
                }
            }

            // Memuat preferensi pengguna saat dokumen siap
            loadPreference();

            function createTab(divId, title) {
                const tab = document.createElement('button');
                tab.classList.add('tab');
                tab.textContent = title;

                tab.addEventListener('click', function() {
                    showTabContent(divId);
                });

                return tab;
            }

            function showTabContent(divId) {
                const tabContent = document.getElementById('tab-content');
                const divs = tabContent.querySelectorAll('div');

                divs.forEach(div => div.classList.add('hide'));

                const contentDiv = document.getElementById(divId);
                contentDiv.classList.remove('hide');
            }

            function showView(viewType) {
                if (viewType === 'single') {
                    document.getElementById('tabs-container').classList.add('hide');
                    divs.forEach(div => div.classList.remove('hide'));
                } else {
                    divs.forEach(div => div.classList.add('hide'));
                    document.getElementById('tabs-container').classList.remove('hide');

                    const tabs = document.getElementById('tabs');
                    tabs.innerHTML = '';

                    const tabContent = document.getElementById('tab-content');
                    tabContent.innerHTML = '';

                    divs.forEach((div, index) => {
                        const tab = createTab(`dif${index + 1}`, div.textContent);
                        tabs.appendChild(tab);

                        const contentDiv = div.cloneNode(true);
                        contentDiv.id = `dif${index + 1}`;
                        contentDiv.classList.add('hide');
                        tabContent.appendChild(contentDiv);
                    });

                    showTabContent('dif1');
                }
            }

            multiViewBtn.addEventListener('click', function() {
                showView('multi');
                savePreference('multi');
            });

            singleViewBtn.addEventListener('click', function() {
                showView('single');
                savePreference('single');
            });


        });
    </script>
</body>

</html>