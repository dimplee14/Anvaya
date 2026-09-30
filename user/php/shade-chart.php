<?php
require_once('header.php');
?>
<?php
include 'db.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shade Chart</title>
    <link rel="stylesheet" href="../css/design.css">
    <link rel="stylesheet" href="../css/shade-chart.css">
</head>
<body>
    <main>
        <section class="shadechart-Studio">
            <div class="design shadechart-design">
                <div class="shadechart-heading heading">
                    <div class="black-head head">
                        Shade<span> Chart</span>
                    </div>
                    <div class="underline">
                        <div class="black-underline1 underline1"></div>
                        <div class="black-underline2 underline2"></div>
                        <div class="black-underline1 underline1"></div>
                    </div>
                </div>
                <div class="shadechart-content content">
                    <p class="black-p p">Explore our fabric shade chart to find the perfect color and material for your needs!</p>
                </div>
            </div>
        </section>
        <section class="shadechart-btns-section">
            <div class="shadechart-btns">
                <div class="shadechart-btns-box">
                    <button class="shadechart-filter-btn active" data-category="All">All</button>
                    <button class="shadechart-filter-btn" data-category="Red">Red</button>
                    <button class="shadechart-filter-btn" data-category="Pink">Pink</button>
                    <button class="shadechart-filter-btn" data-category="Gold">Gold</button>
                    <button class="shadechart-filter-btn" data-category="White">White/Ivory</button>
                    <button class="shadechart-filter-btn" data-category="Green">Green</button>
                    <button class="shadechart-filter-btn" data-category="Blue">Blue</button>
                    <button class="shadechart-filter-btn" data-category="Purple">Purple</button>
                </div>
            </div>
        </section>
        <div class="shadechart-categories-section">
            <div class="shadechart-grid">
            <!-- Red Category Card -->
            <!-- Red Shades as Separate Cards -->
            <div class="shadechart-card" data-category="Red">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#DC143C;"></div>
                    <h3 class="shadechart-card-title">Crimson</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Traditional, auspicious, bold</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Silk, Banarasi &rarr; Bridal lehenga, saree
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Red">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#800000;"></div>
                    <h3 class="shadechart-card-title">Maroon</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Traditional, auspicious, bold</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Velvet, Silk &rarr; Reception gown, sherwani
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Red">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#E34234;"></div>
                    <h3 class="shadechart-card-title">Vermilion</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Traditional, auspicious, bold</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Georgette, Silk &rarr; Haldi outfit, saree
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Red">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#722F37;"></div>
                    <h3 class="shadechart-card-title">Wine</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Traditional, auspicious, bold</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Velvet, Crepe &rarr; Evening gown, blouse
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Red">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#B22222;"></div>
                    <h3 class="shadechart-card-title">Brick Red</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Traditional, auspicious, bold</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Chanderi, Cotton &rarr; Mehndi suit, festive kurta
                    </div>
                </div>
            </div>
            <!-- Pink Category Card -->
            <!-- Pink Shades as Separate Cards -->
            <div class="shadechart-card" data-category="Pink">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#F9C6D0;"></div>
                    <h3 class="shadechart-card-title">Blush</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Romantic, feminine, joyful</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Georgette, Organza &rarr; Engagement gown, dupatta
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Pink">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#FF66CC;"></div>
                    <h3 class="shadechart-card-title">Rose</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Romantic, feminine, joyful</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Silk, Net &rarr; Bridal saree, blouse
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Pink">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#FF00FF;"></div>
                    <h3 class="shadechart-card-title">Fuchsia</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Romantic, feminine, joyful</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Crepe, Georgette &rarr; Sangeet dress, lehenga
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Pink">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#F4C2C2;"></div>
                    <h3 class="shadechart-card-title">Baby Pink</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Romantic, feminine, joyful</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Organza, Chanderi &rarr; Mehndi outfit, suit
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Pink">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#FF69B4;"></div>
                    <h3 class="shadechart-card-title">Hot Pink</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Romantic, feminine, joyful</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Banarasi, Silk &rarr; Traditional saree, lehenga
                    </div>
                </div>
            </div>
            <!-- Gold Category Card -->
            <!-- Gold Shades as Separate Cards -->
            <div class="shadechart-card" data-category="Gold">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#F7E7CE;"></div>
                    <h3 class="shadechart-card-title">Champagne</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Regal, luxurious, festive</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Organza, Silk &rarr; Reception dupatta, gown overlay
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Gold">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#D4AF37;"></div>
                    <h3 class="shadechart-card-title">Antique Gold</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Regal, luxurious, festive</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Banarasi, Velvet &rarr; Bridal lehenga, sherwani
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Gold">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#FFD700;"></div>
                    <h3 class="shadechart-card-title">Yellow Gold</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Regal, luxurious, festive</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Silk, Georgette &rarr; Haldi outfit, saree
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Gold">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#CD7F32;"></div>
                    <h3 class="shadechart-card-title">Bronze</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Regal, luxurious, festive</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Velvet, Crepe &rarr; Evening blouse, jacket
                    </div>
                </div>
            </div>
            <!-- White/Ivory Category Card -->
            <!-- White/Ivory Shades as Separate Cards -->
            <div class="shadechart-card" data-category="White">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#FFFFFF; border:1px solid #ccc;"></div>
                    <h3 class="shadechart-card-title">Pure White</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Purity, elegance, minimalism</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Net, Organza &rarr; Bridal veil, gown overlay
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="White">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#F8F8FF; border:1px solid #ccc;"></div>
                    <h3 class="shadechart-card-title">Off-White</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Purity, elegance, minimalism</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Silk, Chanderi &rarr; Saree, suit
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="White">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#FFFDD0; border:1px solid #ccc;"></div>
                    <h3 class="shadechart-card-title">Cream</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Purity, elegance, minimalism</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Georgette, Crepe &rarr; Reception gown, blouse
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="White">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#F0EAD6; border:1px solid #ccc;"></div>
                    <h3 class="shadechart-card-title">Pearl</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Purity, elegance, minimalism</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Organza, Lace &rarr; Dupatta, sleeves
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="White">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#F0EAD6; border:1px solid #ccc;"></div>
                    <h3 class="shadechart-card-title">Eggshell</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Purity, elegance, minimalism</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Chanderi, Cotton &rarr; Mehndi outfit, kurta
                    </div>
                </div>
            </div>
            <!-- Green Category Card -->
            <!-- Green Shades as Separate Cards -->
            <div class="shadechart-card" data-category="Green">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#AAF0D1;"></div>
                    <h3 class="shadechart-card-title">Mint</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Freshness, prosperity, nature</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Organza, Chanderi &rarr; Mehndi suit, dupatta
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Green">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#808000;"></div>
                    <h3 class="shadechart-card-title">Olive</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Freshness, prosperity, nature</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Crepe, Cotton &rarr; Casual kurta, Indo-western dress
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Green">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#50C878;"></div>
                    <h3 class="shadechart-card-title">Emerald</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Freshness, prosperity, nature</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Velvet, Silk &rarr; Bridal blouse, sherwani
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Green">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#2E8B57;"></div>
                    <h3 class="shadechart-card-title">Sea Green</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Freshness, prosperity, nature</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Georgette, Net &rarr; Sangeet gown, lehenga
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Green">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#006A4E;"></div>
                    <h3 class="shadechart-card-title">Bottle Green</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Freshness, prosperity, nature</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Banarasi, Silk &rarr; Saree, festive wear
                    </div>
                </div>
            </div>
            <!-- Blue Category Card -->
            <!-- Blue Shades as Separate Cards -->
            <div class="shadechart-card" data-category="Blue">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#B0E0E6;"></div>
                    <h3 class="shadechart-card-title">Powder Blue</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Calm, richness, modernity</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Organza, Georgette &rarr; Engagement gown, dupatta
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Blue">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#4169E1;"></div>
                    <h3 class="shadechart-card-title">Royal Blue</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Calm, richness, modernity</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Banarasi, Silk &rarr; Saree, sherwani
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Blue">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#000080;"></div>
                    <h3 class="shadechart-card-title">Navy</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Calm, richness, modernity</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Velvet, Crepe &rarr; Reception gown, blouse
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Blue">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#87CEEB;"></div>
                    <h3 class="shadechart-card-title">Sky Blue</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Calm, richness, modernity</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Chanderi, Cotton &rarr; Mehndi suit, kurta
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Blue">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#008080;"></div>
                    <h3 class="shadechart-card-title">Teal</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Calm, richness, modernity</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Crepe, Georgette &rarr; Indo-western dress, lehenga
                    </div>
                </div>
            </div>
            <!-- Purple Category Card -->
            <!-- Purple Shades as Separate Cards -->
            <div class="shadechart-card" data-category="Purple">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#E6E6FA;"></div>
                    <h3 class="shadechart-card-title">Lavender</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Creativity, luxury, uniqueness</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Organza, Net &rarr; Dupatta, gown overlay
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Purple">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#C8A2C8;"></div>
                    <h3 class="shadechart-card-title">Lilac</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Creativity, luxury, uniqueness</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Georgette, Chanderi &rarr; Mehndi outfit, suit
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Purple">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#E0B0FF;"></div>
                    <h3 class="shadechart-card-title">Mauve</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Creativity, luxury, uniqueness</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Crepe, Silk &rarr; Reception gown, blouse
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Purple">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#8E4585;"></div>
                    <h3 class="shadechart-card-title">Plum</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Creativity, luxury, uniqueness</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Velvet, Banarasi &rarr; Bridal lehenga, sherwani
                    </div>
                </div>
            </div>
            <div class="shadechart-card" data-category="Purple">
                <div class="shadechart-card-content">
                    <div class="shadechart-color-circle" style="background:#8F00FF;"></div>
                    <h3 class="shadechart-card-title">Violet</h3>
                    <div class="shadechart-symbolism"><strong>Symbolism:</strong> Creativity, luxury, uniqueness</div>
                    <div class="shadechart-material-bestfor">
                        <strong>Material & Best For:</strong><br>
                        Silk, Net &rarr; Saree, festive wear
                    </div>
                </div>
            </div>
            </div>
        </div>

    </main>
    <script>
    // Shade chart filter logic with shuffle for 'All'
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.shadechart-filter-btn');
        const grid = document.querySelector('.shadechart-grid');
        const allCards = Array.from(document.querySelectorAll('.shadechart-card'));

        function shuffle(array) {
            let currentIndex = array.length, randomIndex;
            while (currentIndex !== 0) {
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex--;
                [array[currentIndex], array[randomIndex]] = [array[randomIndex], array[currentIndex]];
            }
            return array;
        }

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const selectedCategory = this.getAttribute('data-category');
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Remove all cards from grid
                while (grid.firstChild) grid.removeChild(grid.firstChild);

                let toShow;
                if (selectedCategory === 'All') {
                    // Make all cards visible before shuffling
                    allCards.forEach(card => { card.style.display = ''; });
                    toShow = shuffle([...allCards]);
                } else {
                    // Hide all cards except the selected category
                    allCards.forEach(card => { card.style.display = 'none'; });
                    toShow = allCards.filter(card => card.getAttribute('data-category') === selectedCategory);
                }
                toShow.forEach(card => {
                    card.style.display = '';
                    grid.appendChild(card);
                });
            });
        });
    });
    </script>
     <?php
    require_once("footer.php");
    ?>
</body>
</html>