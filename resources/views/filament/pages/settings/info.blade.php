<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        <x-filament-panels::form.actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>
</x-filament-panels::page>
<script>
    // Restore the scroll position after the page is reloaded
    window.addEventListener("load", function () {
        const scrollPosition = parseInt(
            localStorage.getItem("scrollPosition"),
            10
        );
        if (scrollPosition) {
            window.scrollTo(0, scrollPosition);
            localStorage.removeItem("scrollPosition");
        }
    });
</script>
