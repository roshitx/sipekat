                    <!-- The Modal -->
                    <div id="modal" class="hidden fixed top-0 left-0 z-80 w-screen h-screen bg-black/70 flex justify-center items-center z-50">
                        <!-- The close button -->
                        <div class="p-5 rounded-md hover:bg-primary fixed z-90 top-6 right-8 bg-[#4C4C4C]">
                            <a class="fixed z-90 top-8 right-10 text-white text-5xl font-bold" href="javascript:void(0)" onclick="closeModal()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minimize-2">
                                    <polyline points="4 14 10 14 10 20" />
                                    <polyline points="20 10 14 10 14 4" />
                                    <line x1="14" x2="21" y1="10" y2="3" />
                                    <line x1="3" x2="10" y1="21" y2="14" />
                                </svg>
                            </a>
                        </div>

                        <!-- A big image will be displayed here -->
                        <img id="modal-img" class="max-w-[380px] max-h-[250px] lg:max-w-[1080px] lg:max-h-[960px] object-cover" />
                    </div>

                    <script>
                        // Get the modal by id
                        var modal = document.getElementById("modal");

                        // Get the modal image tag
                        var modalImg = document.getElementById("modal-img");

                        // this function is called when a small image is clicked
                        function showModal(src) {
                            modal.classList.remove('hidden');
                            modalImg.src = src;
                        }

                        // this function is called when the close button is clicked
                        function closeModal() {
                            modal.classList.add('hidden');
                        }

                    </script>
