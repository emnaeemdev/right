(() => {
    const alignmentGroup = 'textAlign';

    const alignments = ['right', 'center', 'left', 'justify'];

    function matchesAlignment(element, align) {
        const inline = (element.style?.textAlign || '').trim();

        if (inline === align) {
            return true;
        }

        return window.getComputedStyle(element).textAlign === align;
    }

    function configureTrixAlignments() {
        if (typeof Trix === 'undefined') {
            return false;
        }

        alignments.forEach((align) => {
            const key = 'textAlign' + align.charAt(0).toUpperCase() + align.slice(1);

            Trix.config.blockAttributes[key] = {
                tagName: 'div',
                style: { textAlign: align },
                group: alignmentGroup,
                parser(element) {
                    return matchesAlignment(element, align);
                },
            };
        });

        return true;
    }

    document.addEventListener('trix-before-initialize', configureTrixAlignments, true);

    document.addEventListener('DOMContentLoaded', () => {
        const waitForTrix = window.setInterval(() => {
            if (configureTrixAlignments()) {
                window.clearInterval(waitForTrix);
            }
        }, 50);

        window.setTimeout(() => window.clearInterval(waitForTrix), 15000);
    });
})();
