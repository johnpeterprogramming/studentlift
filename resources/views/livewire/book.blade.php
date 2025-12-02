<div x-data="{ show_membership_panel : @entangle('showMembershipPanel'), membership_selected: '' }">

    <!-- Tab Selection - Membership Pass is selected by default -->
    <nav class="flex gap-4 justify-center p-2">
        <div class="w-fit outline-1 outline-primary-600 p-2 rounded-md">
            <x-button @click="show_membership_panel = true" white ::class="{'!bg-primary-600 !text-white !border-primary-600 hover:!bg-primary-700': show_membership_panel === true }" label="Membership Pass" />
            <x-button @click="show_membership_panel = false" white ::class="{'!bg-primary-600 !text-white !border-primary-600 hover:!bg-primary-700': show_membership_panel === false }" label="Once-off" />
        </div>
    </nav>


    <!-- Membership Pass panel -->
    <section x-show="show_membership_panel"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0">
        <h2 class="text-3xl text-center my-8 font-bold">Membership Pass</h2>

        <article class="flex justify-center gap-x-5">
            <!-- Semester Pass Card -->
            <x-card
                class="transition-transform duration-300 ease-in-out"
                x-bind:class="{ 'scale-105 outline outline-1 outline-primary-700': membership_selected === 'semester_pass' }"
            >
                <x-slot name="title">
                    <h2 class="text-2xl font-bold">Semester Pass</h2>
                </x-slot>
                <p>Best value for consistent trips. Seat guaranteed all semester</p>
                <p class="text-green-900 font-bold">ZAR 5999/semester</p>

                <x-button @click="membership_selected = 'semester_pass'" primary label="Select Semester Pass" class="mt-6"/>
            </x-card>

            <!-- Monthly Pass Card -->
            <x-card
                class="transition-transform duration-300 ease-in-out"
                x-bind:class="{ 'scale-105 outline outline-1 outline-primary-700': membership_selected === 'monthly_pass' }"
            >
                <x-slot name="title">
                    <h2 class="text-2xl font-bold">Monthly Pass</h2>
                </x-slot>
                <p>Guaranteed Friday & Sunday rides. Priority booking. Cancel anytime.</p>
                <p class="text-green-900 font-bold">ZAR 1499/month</p>

                <x-button @click="membership_selected = 'monthly_pass'" primary label="Select Monthly Pass" class="mt-6"/>
            </x-card>
        </article>

        <!-- Slot Selection -->
        <article class="flex justify-center mt-10"
            x-show="membership_selected != ''"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
        >
            <x-card class="w-200">
                <x-slot name="title">
                    <h2 class="text-2xl font-bold">Choose Weekly timeslots</h2>
                </x-slot>
                <form wire:submit="book" class="px-4">
                    <!-- Departure -->
                    <x-select label="From Location"
                        placeholder="Select Departure Location"
                        class="my-4"
                        :options="$departureAddresses"
                        option-label="name"
                        option-value="value"
                        wire:model.live="selectedDeparture"
                    />

                    <!-- Return -->
                    <x-select label="To Location"
                        placeholder="Select Arrival Timeslot"
                        class="my-4"
                        :options="$arrivalAddresses"
                        option-label="name"
                        option-value="value"
                        wire:model.live="selectedArrival"
                        :disabled="!$selectedDeparture"
                    />

                    <x-button type="submit" label="Continue to Payment" primary/>
                </form>
            </x-card>
        </article>



    </section>

    <!-- Once off panel -->
    <section x-show="!show_membership_panel"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0">

        <article class="flex justify-center mt-8">
            <x-card class="w-200">
                <x-slot name="title">
                    <h2 class="text-2xl font-bold">Choose Timeslot</h2>
                </x-slot>
                <form wire:submit="book" class="px-4">
                    <!-- Departure -->
                    <x-select label="From Location"
                        placeholder="Select Departure Location"
                        class="my-4"
                        :options="$departureAddresses"
                        option-label="name"
                        option-value="value"
                        wire:model.live="selectedDeparture"
                    />

                    <!-- Arrival -->
                    <x-select label="To Location"
                        placeholder="Select Arrival Location"
                        class="my-4"
                        :options="$arrivalAddresses"
                        option-label="name"
                        option-value="value"
                        wire:model.live="selectedArrival"
                        :disabled="!$selectedDeparture"
                    />

                    <x-button type="submit" label="Continue to Payment" primary/>
                </form>
            </x-card>
        </article>
    </section>



</div>
