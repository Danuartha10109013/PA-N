@extends('layouts.app')
@section('content')
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="text-center mb-3">Pengajuan Reimbursment Hari Ini</div>
                    <h1 class="display-4">{{ $count['reimbursment_hari_ini'] }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="text-center mb-3">Total Reimbursment Bulan Ini</div>
                    <h1 class="display-4">{{ $count['rembursment_bulan_ini'] }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="text-center mb-3">Reimburment Menunggu Konfirmasi</div>
                    <h1 class="display-4">{{ $count['reimbursment_pending'] }}</h1>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body text-center">
                    <div class="text-center mb-3">Nominal Reimbursment Bulan Ini</div>
                    <h1 class="display-4">{{ formatRupiah($count['jumlah_reimbursment_bulan_ini']) }}</h1>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <canvas id="reimbursementChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "{{ route('get-data-ajax') }}",
                method: "GET",
                success: function(response) {
                    const labels = response.map(item => item.date);
                    const data = response.map(item => item.total_nominal);

                    const ctx = document.getElementById('reimbursementChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Nominal Reimbursement per Day',
                                data: data,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: true,
                                    text: 'Reimbursement Per Day'
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            });
        });
    </script>
@endpush
