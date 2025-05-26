function generateBarcode() {
    const barcodeContainer = document.getElementById('barcode');
    const lineTypes = ['thin', 'medium', 'thick'];
    const numLines = 40; 
    
    barcodeContainer.innerHTML = '';
    
    for (let i = 0; i < numLines; i++) {
        const line = document.createElement('div');
        line.className = `line ${lineTypes[Math.floor(Math.random() * lineTypes.length)]}`;
        
        if (Math.random() > 0.85) {
            line.style.marginRight = '2px';
        }
        
        barcodeContainer.appendChild(line);
    }
}

document.addEventListener('DOMContentLoaded', generateBarcode);

function regenerateBarcode() {
    generateBarcode();
}