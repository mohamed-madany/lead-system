<x-filament-panels::page.simple>
    <style>
        /* Reset & Page Background */
        .fi-simple-main-ctn {
            background-image: radial-gradient(at 0% 0%, hsla(202, 85%, 95%, 1) 0, transparent 50%),
                radial-gradient(at 50% 0%, hsla(202, 85%, 90%, 1) 0, transparent 50%),
                radial-gradient(at 100% 0%, hsla(202, 85%, 95%, 1) 0, transparent 50%) !important;
            background-attachment: fixed !important;
            min-height: 100vh !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        /* The Card */
        .fi-simple-page-content {
            background-color: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(16px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(16px) saturate(180%) !important;
            border: 1px solid rgba(255, 255, 255, 0.4) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15) !important;
            border-radius: 2rem !important;
            padding: 3rem !important;
            width: 100% !important;
            max-width: 32rem !important;
            margin: 2rem auto !important;
        }

        /* Dark mode overrides for consistency */
        .dark .fi-simple-page-content {
            background-color: rgba(15, 23, 42, 0.8) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
        }

        /* Heading & Logo Polish */
        .fi-simple-header-heading {
            color: #016fb9 !important;
            font-size: 1.875rem !important;
            font-weight: 800 !important;
            letter-spacing: -0.025em !important;
        }

        .fi-simple-header-subheading {
            color: #64748b !important;
            font-size: 1rem !important;
            margin-top: 0.5rem !important;
        }

        .dark .fi-simple-header-subheading {
            color: #94a3b8 !important;
        }

        /* Input Fields */
        .fi-input-wrp {
            background-color: rgba(255, 255, 255, 0.5) !important;
            border-radius: 0.75rem !important;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            transition: all 0.2s ease !important;
        }

        .dark .fi-input-wrp {
            background-color: rgba(30, 41, 59, 0.5) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
        }

        /* Buttons */
        .fi-btn {
            border-radius: 0.75rem !important;
            font-weight: 600 !important;
            padding: 0.625rem 1.25rem !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }

        .fi-btn-primary {
            background-color: #016fb9 !important;
        }

        .fi-btn:hover {
            transform: translateY(-1px) !important;
            box-shadow: 0 10px 15px -3px rgba(1, 111, 185, 0.2) !important;
        }

        /* Brand Color Accents */
        .fi-link {
            color: #016fb9 !important;
            font-weight: 600 !important;
        }
    </style>

    <form wire:submit="authenticate">
        {{ $this->form }}

        <x-filament::actions :actions="$this->getFormActions()" :full-width="$this->hasFullWidthFormActions()" class="mt-6" />
    </form>
</x-filament-panels::page.simple>
