document.addEventListener('DOMContentLoaded', function () {
    // Elements
    const maleBtn = document.querySelector('.male-btn');
    const femaleBtn = document.querySelector('.female-btn');
    const que1Img = document.querySelector('.que1-img img');
    const que2Img = document.querySelector('.que2-img img');
    const sareeCards = Array.from(document.querySelectorAll('.saree-img-group .card .img img'));
    const selectionLightHeading = document.querySelector('.selection-heading .light-heading');
    const sizeChartHeading = document.querySelector('.size-chart .que');
    const designIntro = document.querySelector('.design-content .black-p');
    const que1Label = document.querySelector('.que1 .que');
    const que2Label = document.querySelector('.que2 .que');
    const que2Inputs = Array.from(document.querySelectorAll('.que2 .radio-btn input'));
    const selectionMainLabel = document.querySelector('.selection-heading .que');
    const tellFileLabel = document.querySelector('.tell-file .que');
    const tellMoreLabel = document.querySelector('.tell-us-more .que');
    const form = document.querySelector('.design-form');
    let currentSet = null;

    // Gender sets for female and male
    const femaleSet = {
        que1: '../assets/img/3.7.jpg', // Female question 1 image
        que2: '../assets/img/lehnga1.jpg',   // Female question 2 image
        selectionText: "Female's Collection",
        sizeHeading: 'Female Size Chart',
        designIntro: 'Answer these simple questions and our Design and Styling team will help you Design your own Dream Outfit!',
        que1Text: 'When are you planning to wear it?',
        que2Text: 'Choose Your Perfect Style ',
        selectionMainText: 'Select All Which You Like (Let us Know What You Like)',
        tellFileText: 'Tell us your likes.',
        tellMoreText: 'Tell us more about you.',
        answersQ2: ['Lehenga', 'Saree', 'Anarkali', 'Designer Suits', 'Evening Gown / Party Gown', 'Indo-Western Fusion', 'Custom / Other'],
        cards: [
            { src: '../assets/img/lehnga1.jpg', name: 'Crimson Bridal Lehenga' },
            { src: '../assets/img/saree1.jpg', name: 'Beige Classic Saree' },
            { src: '../assets/img/anarkali3.jpg', name: 'Green Grace Anarkali' },
            { src: '../assets/img/suits4.jpg', name: 'Sky Blue Designer Suit' },
            { src: '../assets/img/Gown5.jpg', name: 'Rose Blush Gown' }
        ],
        styleMap: {
            'Lehenga': [
                { src: '../assets/img/lehnga1.jpg', name: 'Crimson Bridal Lehenga' },
                { src: '../assets/img/lehnga2.jpg', name: 'Champagne Glow Lehenga' },
                { src: '../assets/img/lehnga3.jpg', name: 'Rosé Net Lehenga' },
                { src: '../assets/img/lehnga4.jpg', name: 'Ivory Mirror Lehenga' },
                { src: '../assets/img/lehnga5.jpg', name: 'Midnight Velvet Lehenga' }
            ],
            'Saree': [
                { src: '../assets/img/saree1.jpg', name: 'Beige Classic Saree' },
                { src: '../assets/img/saree2.jpg', name: 'Pink Festive Saree' },
                { src: '../assets/img/saree3.jpg', name: 'Green Silk Saree' },
                { src: '../assets/img/saree4.jpg', name: 'Blue Elegant Saree' },
                { src: '../assets/img/saree5.jpg', name: 'Gold Zari Saree' }
            ],
            'Anarkali': [
                { src: '../assets/img/anarkali1.jpg', name: 'Beige Regal Anarkali' },
                { src: '../assets/img/anarkali2.jpg', name: 'Pink Festive Anarkali' },
                { src: '../assets/img/anarkali3.jpg', name: 'Green Grace Anarkali' },
                { src: '../assets/img/anarkali4.jpg', name: 'Blue Classic Anarkali' },
                { src: '../assets/img/anarkali5.jpg', name: 'Gold Glam Anarkali' }
            ],
            'Designer Suits': [
                { src: '../assets/img/suits1.jpg', name: 'Red Regal Designer Suit' },
                { src: '../assets/img/suits2.jpg', name: 'Pink Grace Designer Suit' },
                { src: '../assets/img/suits3.jpg', name: 'Rose Glow Designer Suit' },
                { src: '../assets/img/suits4.jpg', name: 'Sky Blue Designer Suit' },
                { src: '../assets/img/suits5.jpg', name: 'Navy Charm Designer Suit' }
            ],
            'Evening Gown / Party Gown': [
                { src: '../assets/img/Gown1.jpg', name: 'Red Glam Gown' },
                { src: '../assets/img/Gown2.jpg', name: 'Pink Sparkle Gown' },
                { src: '../assets/img/Gown3.jpg', name: 'Blue Flow Gown' },
                { src: '../assets/img/Gown4.jpg', name: 'Gold Shine Gown' },
                { src: '../assets/img/Gown5.jpg', name: 'Rose Blush Gown' }
            ],
            'Indo-Western Fusion': [
                { src: '../assets/img/Indo-Western1.jpg', name: 'Red Chic Indo-Western' },
                { src: '../assets/img/Indo-Western2.jpg', name: 'Pink Glow Indo-Western' },
                { src: '../assets/img/Indo-Western3.jpg', name: 'Beige Fusion Indo-Western' },
                { src: '../assets/img/Indo-Western4.jpg', name: 'Blue Edge Indo-Western' },
                { src: '../assets/img/Indo-Western5.jpg', name: 'Gold Glam Indo-Western' }
            ],
            'Custom / Other': [
                { src: '../assets/img/Indo-Western1.jpg', name: 'Red Chic Indo-Western' },
                { src: '../assets/img/Gown2.jpg', name: 'Pink Sparkle Gown' },
                { src: '../assets/img/suits3.jpg', name: 'Rose Glow Designer Suit' },
                { src: '../assets/img/anarkali4.jpg', name: 'Blue Classic Anarkali' },
                { src: '../assets/img/lehnga5.jpg', name: 'Midnight Velvet Lehenga' }
            ]
        }
    };

    const maleSet = {
        que1: '../assets/img/Bandhgala1.jpg', // Male question 1 image
        que2: '../assets/img/Kurta1.jpg',     // Male question 2 image
        selectionText: "Men's Collection",
        sizeHeading: 'Male Size Chart',
        designIntro: 'Answer these simple questions and our Design and Styling team will help you Design your own Dream Outfit!',
        que1Text: 'For which occasion do you want this outfit?',
        que2Text: 'Choose Your Perfect Style ',
        selectionMainText: 'Select All Which You Like (Let us Know What You Like)',
        tellFileText: 'Tell us your likes.',
        tellMoreText: 'Tell us more about you.',
        answersQ2: ['Bandhgala', 'Casual Shirt', 'Kurta', 'Sherwani', 'Designer Suits', 'jodhpuri', 'Custom / Other'],
        cards: [
            { src: '../assets/img/Kurta1.jpg', name: 'White Classic Kurta' },
            { src: '../assets/img/Casual Shirt2.jpg', name: 'White Classic Casual Shirt' },
            { src: '../assets/img/Sherwani3.jpg', name: 'White Classic Sherwani' },
            { src: '../assets/img/Suitm4.jpg', name: 'Beige Royal Designer Suit' },
            { src: '../assets/img/jodhpuri5.jpg', name: 'Maroon Royal Jodhpuri' }


        ],
        styleMap: {
            'Kurta': [
                { src: '../assets/img/Kurta1.jpg', name: 'White Classic Kurta' },
                { src: '../assets/img/Kurta2.jpg', name: 'Cream Festive Kurta' },
                { src: '../assets/img/Kurta3.jpg', name: 'Beige Traditional Kurta' },
                { src: '../assets/img/Kurta4.jpg', name: 'Off-White Elegant Kurta' },
                { src: '../assets/img/Kurta5.jpg', name: 'Light Brown Ethnic Kurta' }
            ],
            'Bandhgala': [
                { src: '../assets/img/Bandhgala1.jpg', name: 'Black Royal Bandhgala' },
                { src: '../assets/img/Bandhgala2.jpg', name: 'Maroon Classic Bandhgala' },
                { src: '../assets/img/Bandhgala3.jpg', name: 'Pink Regal Bandhgala' },
                { src: '../assets/img/Bandhgala4.jpg', name: 'Blue Grace Bandhgala' },
                { src: '../assets/img/Bandhgala5.jpg', name: 'Beige Elegant Bandhgala' }
            ],
            'Casual Shirt': [
                { src: '../assets/img/Casual Shirt1.jpg', name: 'Black Urban Casual Shirt' },
                { src: '../assets/img/Casual Shirt2.jpg', name: 'White Classic Casual Shirt' },
                { src: '../assets/img/Casual Shirt3.jpg', name: 'Blue Printed Casual Shirt' },
                { src: '../assets/img/Casual Shirt4.jpg', name: 'Red Bold Casual Shirt' },
                { src: '../assets/img/Casual Shirt5.jpg', name: 'Grey Chill Casual Shirt' }
            ],
            'Sherwani': [
                { src: '../assets/img/Sherwani1.jpg', name: 'Cream Regal Sherwani' },
                { src: '../assets/img/Sherwani2.jpg', name: 'Beige Embroidered Sherwani' },
                { src: '../assets/img/Sherwani3.jpg', name: 'White Classic Sherwani' },
                { src: '../assets/img/Sherwani4.jpg', name: 'Gold Royal Sherwani' },
                { src: '../assets/img/Sherwani5.jpg', name: 'Ivory Elegant Sherwani' }
            ],
            'Designer Suits': [
                { src: '../assets/img/Suitm1.jpg', name: 'Black Classic Designer Suit' },
                { src: '../assets/img/Suitm2.jpg', name: 'Cream Embroidered Suit' },
                { src: '../assets/img/Suitm3.jpg', name: 'White Regal Designer Suit' },
                { src: '../assets/img/Suitm4.jpg', name: 'Beige Royal Designer Suit' },
                { src: '../assets/img/Suitm5.jpg', name: 'Ivory Elegant Designer Suit' }
            ],
            'jodhpuri': [
                { src: '../assets/img/jodhpuri1.jpg', name: 'Black Classic Jodhpuri' },
                { src: '../assets/img/jodhpuri2.jpg', name: 'Navy Regal Jodhpuri' },
                { src: '../assets/img/jodhpuri3.jpg', name: 'Beige Embroidered Jodhpuri' },
                { src: '../assets/img/jodhpuri4.jpg', name: 'Ivory Elegant Jodhpuri' },
                { src: '../assets/img/jodhpuri5.jpg', name: 'Maroon Royal Jodhpuri' }
            ],
            'Custom / Other': [
                { src: '../assets/img/jodhpuri1.jpg', name: 'Black Classic Jodhpuri' },
                { src: '../assets/img/Suitm2.jpg', name: 'Cream Embroidered Suit' },
                { src: '../assets/img/Sherwani3.jpg', name: 'White Classic Sherwani' },
                { src: '../assets/img/Casual Shirt4.jpg', name: 'Red Bold Casual Shirt' },
                { src: '../assets/img/Kurta5.jpg', name: 'Light Brown Ethnic Kurta' }
            ]

        }
    };

    // Set gender
    function setGender(gender) {
        const set = gender === 'male' ? maleSet : femaleSet;
        currentSet = set;

        if (que1Img) que1Img.src = set.que1;
        if (que2Img) que2Img.src = set.que2;

        // Update carousel cards
        if (sareeCards.length) {
            sareeCards.forEach((img, i) => {
                const cardData = set.cards[i % set.cards.length];
                img.src = cardData.src;
                const nameDiv = img.parentElement.nextElementSibling;
                if (nameDiv) nameDiv.textContent = cardData.name;
            });
        }

        if (selectionLightHeading) selectionLightHeading.textContent = set.selectionText;
        if (sizeChartHeading) sizeChartHeading.textContent = set.sizeHeading;
        if (designIntro) designIntro.textContent = set.designIntro;
        if (que1Label) que1Label.textContent = set.que1Text;
        if (que2Label) que2Label.textContent = set.que2Text;
        if (selectionMainLabel) selectionMainLabel.textContent = set.selectionMainText;
        if (tellFileLabel) tellFileLabel.textContent = set.tellFileText;
        if (tellMoreLabel) tellMoreLabel.textContent = set.tellMoreText;

        // Update option labels
        const que2OptionLabels = Array.from(document.querySelectorAll('.que2 .radio-btn label'));
        if (que2OptionLabels && set.answersQ2) {
            que2OptionLabels.forEach((lbl, idx) => {
                lbl.textContent = set.answersQ2[idx] || lbl.textContent;
            });
        }

        // Clear previous selections in question 2
        if (que2Inputs) que2Inputs.forEach(i => i.checked = false);

        // Active button style
        maleBtn.classList.toggle('active', gender === 'male');
        femaleBtn.classList.toggle('active', gender === 'female');
    }

    // Update carousel when style selected in Q2
    function updateSelectionHeadingFromQue2() {
        if (!selectionLightHeading) return;
        const selected = que2Inputs.filter(i => i.checked).map(input => {
            const label = input.nextElementSibling;
            return label ? label.textContent.trim() : null;
        }).filter(Boolean);

        if (selected.length === 0) {
            selectionLightHeading.textContent = currentSet.selectionText;
            // Reset carousel
            if (currentSet && currentSet.cards) {
                sareeCards.forEach((img, i) => {
                    const cardData = currentSet.cards[i % currentSet.cards.length];
                    img.src = cardData.src;
                    const nameDiv = img.parentElement.nextElementSibling;
                    if (nameDiv) nameDiv.textContent = cardData.name;
                });
            }
        } else {
            selectionLightHeading.textContent = selected.length === 1 ? selected[0] : selected.join(' / ');
            const first = selected[0];
            if (currentSet.styleMap && currentSet.styleMap[first]) {
                const styleCards = currentSet.styleMap[first];
                sareeCards.forEach((img, i) => {
                    const cardData = styleCards[i % styleCards.length];
                    if (cardData) {
                        img.src = cardData.src;
                        const nameDiv = img.parentElement.nextElementSibling;
                        if (nameDiv) nameDiv.textContent = cardData.name;
                    }
                });
            }
        }
    }

    // Collect selected products before form submission
    function collectSelectedProducts() {
        const selected = [];
        document.querySelectorAll('.saree-img-group .card.selected-style-img').forEach(card => {
            const nameDiv = card.querySelector('.img + div');
            if (nameDiv) selected.push(nameDiv.textContent.trim());
        });
        document.getElementById('selected_products').value = selected.join(',');
    }

    // Attach events
    if (maleBtn) maleBtn.addEventListener('click', () => setGender('male'));
    if (femaleBtn) femaleBtn.addEventListener('click', () => setGender('female'));
    if (que2Inputs) que2Inputs.forEach(i => i.addEventListener('change', updateSelectionHeadingFromQue2));

    // Make carousel cards selectable
    document.querySelectorAll('.saree-img-group .card').forEach(card => {
            card.addEventListener('click', function() {
                card.classList.toggle('selected-style-img');
                card.classList.toggle('active');
                // Add/remove 'active' class to the img inside .img
                const img = card.querySelector('.img');
                if (img) {
                    img.classList.toggle('active', card.classList.contains('active'));
                }
            });
        });

    // Update hidden input before form submit
    if (form) {
        form.addEventListener('submit', collectSelectedProducts);
    }

    // Initialize default gender
    setGender('female');
});
