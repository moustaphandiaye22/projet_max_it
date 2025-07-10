<script src="https://cdn.tailwindcss.com"></script>
<style>
    body {
        background-color: #e5e7eb;
    }

    .main-content {
        background-color: #ffffff;
        min-height: 100vh;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .balance-card {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    }

    .action-card {
        background-color: #1f2937;
    }

    .promo-card {
        background: linear-gradient(135deg, #f97316 0%, #1f2937 100%);
    }

    .transaction-positive {
        color: #10b981;
    }

    .transaction-negative {
        color: #ef4444;
    }
</style>
<body class="bg-gray-200 min-h-screen">
   
    <div class="flex">
        <!-- Sidebar -->
        <div class="sidebar w-64 min-h-screen p-6">
            <!-- Logo -->
           <div class="flex-1 flex items-center justify-center">
                <div class="flex items-center">
                    <img src="/images/uploads/unnamed.png" alt="Logo" class="h-32 w-32">
                </div>
            </div>
            <br>
            <br>
            <br>
            <!-- Navigation -->
            <nav class="space-y-2">
                <a href="#" class="flex items-center space-x-3 p-3 rounded-lg bg-orange-50 text-orange-500 font-medium">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                    <span>Overview</span>
                </a>
                <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                    </svg>
                    <span>Accounts</span>
                </a>
                <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"></path>
                    </svg>
                    <span>Transactions</span>
                </a>
                <a href="#" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Profile</span>
                </a>
            </nav>
            <!-- Logout -->
            <div class="mt-auto pt-20">
                <a href="/logout" class="flex items-center space-x-3 p-3 rounded-lg text-gray-700 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Logout</span>
                </a>
            </div>
        </div>
        <!-- Main Content -->
        <div class="flex-1 main-content p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Balance Card -->
                    <div class="balance-card rounded-lg p-6 text-white">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium">Solde du compte Principal</h3>
                            <div class="flex items-center space-x-2">
                                <div class="bg-white text-orange-500 p-2 rounded">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                </div>
                                <select class="bg-transparent border border-white/30 rounded px-3 py-1 text-white">
                                    <option>Principal</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-3xl font-bold mb-4">44,500.00</div>
                        <div class="flex justify-end">
                            <button class="bg-orange-600 hover:bg-orange-700 text-white p-2 rounded">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Action Cards -->
                    <div class="grid grid-cols-3 gap-4">
                        <div class="action-card rounded-lg p-4 text-white text-center">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                            </svg>
                            <div class="text-sm font-medium">Paiement</div>
                        </div>
                        <div class="action-card rounded-lg p-4 text-white text-center">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 5a1 1 0 100 2h5.586l-1.293 1.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L13.586 5H8zM12 15a1 1 0 100-2H6.414l1.293-1.293a1 1 0 10-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L6.414 15H12z"></path>
                            </svg>
                            <div class="text-sm font-medium">Transfert</div>
                        </div>
                        <div class="action-card rounded-lg p-4 text-white text-center">
                            <svg class="w-8 h-8 mx-auto mb-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                            </svg>
                            <div class="text-sm font-medium">Forfait sakanal</div>
                        </div>
                    </div>

                    <!-- Promo Card -->
                    <div class="promo-card rounded-lg p-6 text-white relative overflow-hidden flex items-center justify-center" style="height:180px;">
                        <img src="/images/uploads/images.jpeg" alt="Logo" class="absolute inset-0 w-full h-full object-cover opacity-80">
                        
                    </div>
                </div>

                <!-- Right Column - Transactions -->
                <div class="space-y-6">
                    <div class="bg-white rounded-lg p-6 shadow-sm">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium">Transactions</h3>
                            <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm">
                                voir plus →
                            </button>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                                    <div>
                                        <div class="text-sm font-medium">Ousmane Jamvi</div>
                                        <div class="text-xs text-gray-500">06 Mai 2023 - 06:38</div>
                                    </div>
                                </div>
                                <div class="transaction-negative font-semibold">-10,000.00</div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                                    <div>
                                        <div class="text-sm font-medium">Ousmane Jamvi</div>
                                        <div class="text-xs text-gray-500">06 Mai 2023 - 06:38</div>
                                    </div>
                                </div>
                                <div class="transaction-positive font-semibold">+10,000.00</div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                                    <div>
                                        <div class="text-sm font-medium">Ousmane Jamvi</div>
                                        <div class="text-xs text-gray-500">06 Mai 2023 - 06:38</div>
                                    </div>
                                </div>
                                <div class="transaction-negative font-semibold">-10,000.00</div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                                    <div>
                                        <div class="text-sm font-medium">Ousmane Jamvi</div>
                                        <div class="text-xs text-gray-500">06 Mai 2023 - 06:38</div>
                                    </div>
                                </div>
                                <div class="transaction-positive font-semibold">+10,000.00</div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                                    <div>
                                        <div class="text-sm font-medium">Ousmane Jamvi</div>
                                        <div class="text-xs text-gray-500">06 Mai 2023 - 06:38</div>
                                    </div>
                                </div>
                                <div class="transaction-negative font-semibold">-10,000.00</div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                                    <div>
                                        <div class="text-sm font-medium">Ousmane Jamvi</div>
                                        <div class="text-xs text-gray-500">06 Mai 2023 - 06:38</div>
                                    </div>
                                </div>
                                <div class="transaction-positive font-semibold">+10,000.00</div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                                    <div>
                                        <div class="text-sm font-medium">Ousmane Jamvi</div>
                                        <div class="text-xs text-gray-500">06 Mai 2023 - 06:38</div>
                                    </div>
                                </div>
                                <div class="transaction-negative font-semibold">-10,000.00</div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 bg-gray-200 rounded-full"></div>
                                    <div>
                                        <div class="text-sm font-medium">Ousmane Jamvi</div>
                                        <div class="text-xs text-gray-500">06 Mai 2023 - 06:38</div>
                                    </div>
                                </div>
                                <div class="transaction-positive font-semibold">+10,000.00</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
