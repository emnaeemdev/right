import Trix from 'trix'

const alignmentTags = {
    textAlignRight: 'align-right',
    textAlignCenter: 'align-center',
    textAlignLeft: 'align-left',
    textAlignJustify: 'align-justify',
}

function defineAlignElement(tagName, textAlign) {
    if (customElements.get(tagName)) {
        return
    }

    customElements.define(
        tagName,
        class extends HTMLElement {
            connectedCallback() {
                this.style.display = 'block'
                this.style.width = '100%'
                this.style.textAlign = textAlign
            }
        },
    )
}

Object.values(alignmentTags).forEach((tagName) => {
    const align = tagName.replace('align-', '')

    defineAlignElement(tagName, align)
})

Object.entries(alignmentTags).forEach(([attribute, tagName]) => {
    Trix.config.blockAttributes[attribute] = {
        tagName,
        parse: true,
        nestable: false,
        exclusive: true,
        breakOnReturn: true,
        group: false,
        parser(element) {
            return element.tagName.toLowerCase() === tagName
        },
        test(element) {
            return element.tagName.toLowerCase() === tagName
        },
    }
})

Trix.config.dompurify.ADD_TAGS = [
    ...(Trix.config.dompurify.ADD_TAGS ?? []),
    ...Object.values(alignmentTags),
]

Trix.config.blockAttributes.default.tagName = 'p'

Trix.config.blockAttributes.default.breakOnReturn = true

Trix.config.blockAttributes.heading = {
    tagName: 'h2',
    terminal: true,
    breakOnReturn: true,
    group: false,
}

Trix.config.blockAttributes.subHeading = {
    tagName: 'h3',
    terminal: true,
    breakOnReturn: true,
    group: false,
}

Trix.config.textAttributes.underline = {
    style: { textDecoration: 'underline' },
    inheritable: true,
    parser: (element) => {
        const style = window.getComputedStyle(element)

        return style.textDecoration.includes('underline')
    },
}

Trix.Block.prototype.breaksOnReturn = function () {
    const lastAttribute = this.getLastAttribute()
    const blockConfig =
        Trix.config.blockAttributes[lastAttribute ? lastAttribute : 'default']

    return blockConfig?.breakOnReturn ?? false
}

Trix.LineBreakInsertion.prototype.shouldInsertBlockBreak = function () {
    if (
        this.block.hasAttributes() &&
        this.block.isListItem() &&
        !this.block.isEmpty()
    ) {
        return this.startLocation.offset > 0
    } else {
        return !this.shouldBreakFormattedBlock() ? this.breaksOnReturn : false
    }
}

export default function richEditorFormComponent({ state, initialContent = '' }) {
    return {
        state,
        isHydrating: true,

        init: function () {
            if ((!this.state || this.state === '') && initialContent) {
                this.state = initialContent
            }

            const loadStateIntoEditor = () => {
                if (! this.$refs.trix?.editor) {
                    return false
                }

                const html = this.state ?? ''

                this.$refs.trixValue.value = html
                this.$refs.trix.editor.loadHTML(html)

                return true
            }

            const finishHydrating = () => {
                setTimeout(() => {
                    this.isHydrating = false
                }, 150)
            }

            const tryLoad = (attempt = 0) => {
                if (loadStateIntoEditor()) {
                    finishHydrating()

                    return
                }

                if (attempt >= 30) {
                    finishHydrating()

                    return
                }

                setTimeout(() => tryLoad(attempt + 1), 50)
            }

            this.$nextTick(() => tryLoad())

            this.$watch('state', () => {
                if (document.activeElement === this.$refs.trix) {
                    return
                }

                loadStateIntoEditor()
            })
        },
    }
}
