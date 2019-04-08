document.addEventListener('DOMContentLoaded', function() {

    // Encodes/decodes string into ROT-13 format
    String.prototype.rot13 = function() {
        return this.replace(/[a-zA-Z]/g, function(c){
            return String.fromCharCode((c <= "Z" ? 90 : 122) >= (c = c.charCodeAt(0) + 13) ? c : c - 26);
        });
    };

    // Get all elements that have been encoded
    var encoded = document.getElementsByClassName('rot13-encoded');

    // Decode text in each matched element
    Array.prototype.forEach.call(encoded, function(el, i) {
        var text = el.innerHTML.rot13();
        el.innerHTML = text;
    });

});
