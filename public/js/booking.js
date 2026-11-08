// public/js/booking.js
// Vanilla JavaScript for CINEMATIX Seat Map & Real-time Booking Calculation

document.addEventListener('DOMContentLoaded', function () {
    const seatMap = document.getElementById('seat-map');
    if (!seatMap) return;

    const pricePerSeat = parseFloat(seatMap.dataset.price || '0');
    const seatsInput = document.getElementById('seats-input');
    const selectedSeatsDisplay = document.getElementById('selected-seats-display');
    const totalPriceDisplay = document.getElementById('total-price-display');
    const bookingForm = document.getElementById('booking-form');
    const submitBtn = document.getElementById('submit-booking-btn');

    let selectedSeats = [];

    // Check if initial seats are set in hidden input (e.g. from old input or default demo)
    if (seatsInput && seatsInput.value.trim() !== '') {
        const raw = seatsInput.value.split(',').map(s => s.trim()).filter(Boolean);
        // Only keep seats that are NOT disabled/occupied on the map
        selectedSeats = raw.filter(seatCode => {
            const btn = seatMap.querySelector(`[data-seat="${seatCode}"]`);
            return btn && !btn.disabled && !btn.classList.contains('seat-occupied');
        });
    }

    const formatRupiah = (number) => {
        return 'Rp' + new Intl.NumberFormat('id-ID').format(number);
    };

    const updateDisplay = () => {
        // Update hidden input
        if (seatsInput) {
            seatsInput.value = selectedSeats.join(',');
        }

        // Update selected seats label
        if (selectedSeatsDisplay) {
            selectedSeatsDisplay.textContent = selectedSeats.length > 0 
                ? selectedSeats.slice().sort().join(', ') 
                : '-';
        }

        // Update total price label
        if (totalPriceDisplay) {
            const total = selectedSeats.length * pricePerSeat;
            totalPriceDisplay.textContent = formatRupiah(total);
        }

        // Update submit button state
        if (submitBtn) {
            submitBtn.disabled = selectedSeats.length === 0;
            if (selectedSeats.length === 0) {
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
    };

    // Attach click listener to all seat buttons using querySelectorAll and addEventListener
    const seatButtons = seatMap.querySelectorAll('.seat-btn');
    seatButtons.forEach(button => {
        const seatCode = button.dataset.seat;
        const isOccupied = button.classList.contains('seat-occupied') || button.disabled;

        // Sync initial state if seat was already selected
        if (!isOccupied && selectedSeats.includes(seatCode)) {
            button.classList.add('seat-selected');
            button.classList.remove('seat-available');
        }

        button.addEventListener('click', function (e) {
            e.preventDefault();

            if (isOccupied) return;

            const index = selectedSeats.indexOf(seatCode);

            if (index > -1) {
                // Deselect
                selectedSeats.splice(index, 1);
                button.classList.remove('seat-selected');
                button.classList.add('seat-available');
            } else {
                // Select (maximum 8 seats)
                if (selectedSeats.length >= 8) {
                    alert('Maksimal pemesanan adalah 8 kursi per transaksi.');
                    return;
                }
                selectedSeats.push(seatCode);
                button.classList.add('seat-selected');
                button.classList.remove('seat-available');
            }

            updateDisplay();
        });
    });

    // Form submit validation
    if (bookingForm) {
        bookingForm.addEventListener('submit', function (e) {
            if (selectedSeats.length === 0) {
                e.preventDefault();
                alert('Silakan pilih minimal 1 kursi sebelum melanjutkan pemesanan.');
            }
        });
    }

    // Initial calculation
    updateDisplay();
});
