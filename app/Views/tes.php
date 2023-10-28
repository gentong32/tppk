<!DOCTYPE html>
<html>

<head>
    <style>
        .tab {
            display: none;
        }

        button {
            background-color: #ccc;
            border: none;
            color: #000;
            padding: 10px 20px;
            cursor: pointer;
        }

        .aktif {
            background-color: blue;
            color: #fff;
        }
    </style>
</head>

<body onload="openTab('tab1')">
    <button onclick="openTab('tab1')" id="btntab1">Tab 1</button>
    <button onclick=" openTab('tab2')" id="btntab2">Tab 2</button>
    <button onclick="openTab('tab3')" id="btntab3">Tab 3</button>

    <div id="tab1" class="tab">
        <h2>Isi Tab 1</h2>
        <p>Ini adalah isi dari tab 1.</p>
    </div>

    <div id="tab2" class="tab">
        <h2>Isi Tab 2</h2>
        <p>Ini adalah isi dari tab 2.</p>
    </div>

    <div id="tab3" class="tab">
        <h2>Isi Tab 3</h2>
        <p>Ini adalah isi dari tab 3.</p>
    </div>

    <script>
        function openTab(tabName) {
            var i, tabContent;

            // Sembunyikan semua tab
            tabContent = document.getElementsByClassName("tab");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }

            // Hapus kelas 'active' dari semua tombol
            var buttons = document.getElementsByTagName("button");
            for (i = 0; i < buttons.length; i++) {
                buttons[i].classList.remove("aktif");
            }

            // Tampilkan tab yang dipilih
            document.getElementById(tabName).style.display = "block";

            // Tambahkan kelas 'active' pada tombol yang dipilih
            document.getElementById("btn" + tabName).classList.add("aktif");
        }
    </script>
</body>

</html>