<?php
include 'db.php';?>
<?php
require_once('header.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <link rel="stylesheet" href="../css/portfolio.css">
    <link rel="stylesheet" href="../css/media/portfolio.css">
</head>

<body>
    <main>
        <section class="portfolio">
            <div class="portfolio-heading heading">
                <div class="black-head head">
                    Good is in <span> The Details</span>
                </div>
                <div class="underline">
                    <div class="black-underline1 underline1"></div>
                    <div class="black-underline2 underline2"></div>
                    <div class="black-underline1 underline1"></div>
                </div>
            </div>

            <div class="design-content content">
                <p class="black-p p">
                    Experience our craftsmanship... inspirations to moodboards, designs to sketches, patterns to khakhas, zardozis to zari, resham strings to gota patti, swatches to samples, modern drapes to traditional kalidars, bridal lehengas to cocktail gowns — every creation tells a story.

                </p>
            </div>
        </section>

        <!-- Category Buttons -->
        <section class="btns-section">
            <div class="btns">
                <div class="btns-box">
                    <button class="filter-btn active">All</button>
                    <button class="filter-btn">Bridal</button>
                    <button class="filter-btn">Groomwear</button>
                    <button class="filter-btn">Festive</button>
                    <button class="filter-btn">Reception</button>
                </div>
            </div>
        </section>

        <!-- Images Section -->
        <section class="imgs">
            <div class="img-box">

                <!-- bridal -->

                <div class="img1" data-category="Bridal">
                    <img src="../assets/img/bridal1.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Maroon Gold Romance</p></div>
                </div>
                <div class="img1" data-category="Bridal">
                    <img src="../assets/img/bridal2.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Royal Red Legacy</p></div>
                </div>
                <div class="img1" data-category="Bridal">
                    <img src="../assets/img/bridal3.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Palace Glow Bride</p></div>
                </div>
                <div class="img1" data-category="Bridal">
                    <img src="../assets/img/bridal4.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Velvet Maroon Grace</p></div>
                </div>
                <div class="img1" data-category="Bridal">
                    <img src="../assets/img/bridal5.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Champagne Regal Trail</p></div>
                </div>
                <div class="img1" data-category="Bridal">
                    <img src="../assets/img/bridal6.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Mughal Motif Splendor</p></div>
                </div>
                <div class="img1" data-category="Bridal">
                    <img src="../assets/img/bridal7.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Silver-Red Elegance</p></div>
                </div>
                <div class="img1" data-category="Bridal">
                    <img src="../assets/img/bridal8.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Heritage Hall Bride</p></div>
                </div>
                <div class="img1" data-category="Bridal">
                    <img src="../assets/img/bridal9.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Floral Champagne Luxe</p></div>
                </div>
                <div class="img1" data-category="Bridal">
                    <img src="../assets/img/bridal10.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Peacock Garden Queen</p></div>
                </div>
                <div class="img1" data-category="Bridal">
                    <img src="../assets/img/bridal11.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Golden Frame Bride</p></div>
                </div>
                <div class="img1" data-category="Bridal">
                    <img src="../assets/img/bridal12.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Rustic Royal Ensemble</p></div>
                </div>

                <!-- Groomwear -->
                <div class="img2" data-category="Groomwear">
                    <img src="../assets/img/groom1.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Regal Red Sherwani</p></div>
                </div>
                <div class="img2" data-category="Groomwear">
                    <img src="../assets/img/groom2.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Velvet Turban Majesty</p></div>
                </div>
                <div class="img2" data-category="Groomwear">
                    <img src="../assets/img/groom3.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Black Royal Embroidery</p></div>
                </div>
                <div class="img2" data-category="Groomwear">
                    <img src="../assets/img/groom4.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Golden Bloom Jacket</p></div>
                </div>
                <div class="img2" data-category="Groomwear">
                    <img src="../assets/img/groom5.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Nature Scene Nehru</p></div>
                </div>
                <div class="img2" data-category="Groomwear">
                    <img src="../assets/img/groom6.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Pearl Trim Sherwani</p></div>
                </div>
                <div class="img2" data-category="Groomwear">
                    <img src="../assets/img/groom7.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Diagonal Button Black</p></div>
                </div>
                <div class="img2" data-category="Groomwear">
                    <img src="../assets/img/groom8.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Paisley Waistcoat Charm</p></div>
                </div>
                
                <!-- festive -->
                <div class="img3" data-category="Festive">
                    <img src="../assets/img/festive1.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Red Regal Waistband</p></div>
                </div>
                <div class="img3" data-category="Festive">
                    <img src="../assets/img/festive2.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Patchwork Ivy Fusion</p></div>
                </div>
                <div class="img3" data-category="Festive">
                    <img src="../assets/img/festive3.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Pastel Pearl Ensemble</p></div>
                </div>
                <div class="img3" data-category="Festive">
                    <img src="../assets/img/festive4.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Mauve Luxe Lehenga</p></div>
                </div>
                <div class="img3" data-category="Festive">
                    <img src="../assets/img/festive5.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Multicolor Kurta Bloom</p></div>
                </div>
                <div class="img3" data-category="Festive">
                    <img src="../assets/img/festive6.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Peach Floral Salwar</p></div>
                </div>
                <div class="img3" data-category="Festive">
                    <img src="../assets/img/festive7.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Palm Embroidered Nehru</p></div>
                </div>
                <div class="img3" data-category="Festive">
                    <img src="../assets/img/festive8.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Magenta Petal Layers</p></div>
                </div>
                <div class="img3" data-category="Festive">
                    <img src="../assets/img/festive9.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Golden Dhoti Elegance</p></div>
                </div>
                <div class="img3" data-category="Festive">
                    <img src="../assets/img/festive10.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Paisley Vest Fusion</p></div>
                </div>
                <div class="img3" data-category="Festive">
                    <img src="../assets/img/festive11.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Midnight Sheer Sherwani</p></div>
                </div>
                

                <!-- reception -->
                <div class="img4" data-category="Reception">
                    <img src="../assets/img/reception1.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Midnight Floral Lehenga</p></div>
                </div>
                <div class="img4" data-category="Reception">
                    <img src="../assets/img/reception2.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Champagne Mirror Trail</p></div>
                </div>
                <div class="img4" data-category="Reception">
                    <img src="../assets/img/reception3.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Fringe Luxe Ensemble</p></div>
                </div>
                <div class="img4" data-category="Reception">
                    <img src="../assets/img/reception4.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Navy Stud Sherwani</p></div>
                </div>
                <div class="img4" data-category="Reception">
                    <img src="../assets/img/reception5.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Petal Floor Jacket</p></div>
                </div>
                <div class="img4" data-category="Reception">
                    <img src="../assets/img/reception6.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Black Gold Thronewear</p></div>
                </div>
                <div class="img4" data-category="Reception">
                    <img src="../assets/img/reception7.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Cream Beaded Layers</p></div>
                </div>
                <div class="img4" data-category="Reception">
                    <img src="../assets/img/reception8.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Garden Gold Sherwani</p></div>
                </div>
                <div class="img4" data-category="Reception">
                    <img src="../assets/img/reception9.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Golden Walkway Duo</p></div>
                </div>
                <div class="img4" data-category="Reception">
                    <img src="../assets/img/reception10.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Corridor Dance Glam</p></div>
                </div>
                <div class="img4" data-category="Reception">
                    <img src="../assets/img/reception11.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Candlelight Regal Pair</p></div>
                </div>
                <div class="img4" data-category="Reception">
                    <img src="../assets/img/reception12.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Champagne Embroidered Duo</p></div>
                </div>
                <div class="img4" data-category="Reception">
                    <img src="../assets/img/reception13.jpg" alt="">
                    <div class="overlay"><p class="overlay-text">Midnight Gold Ballroom</p></div>
                </div>
                
                <!-- Continue assigning categories similarly for img9–img15 -->
            </div>
        </section>

        <div class="submit-btn">
            <a href="process.php"><button>Explore Our Process</button></a>
        </div>
    </main>

    <script src="../js/portfolio.js"></script>
    <?php require_once("footer.php"); ?>
</body>
</html>
