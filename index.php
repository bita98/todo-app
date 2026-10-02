<?php

require_once "db.php";

$result = $conn->query(
    "SELECT id, title, created_at FROM todos ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Todo App</title>

    <link rel="stylesheet" href="src/output.css">
</head>

<body class="min-h-screen bg-gradient-to-br from-violet-50 via-white to-pink-50 text-slate-800">

    <main class="mx-auto min-h-screen max-w-2xl px-4 py-10 sm:px-6">

        <section class="rounded-[28px] border border-white bg-white/90 p-5 shadow-[0_20px_60px_rgba(139,92,246,0.10)] backdrop-blur sm:p-8">

            <div class="mb-8 text-center">

                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-500 text-white shadow-lg shadow-violet-200">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-7 w-7"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>

                </div>

                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    لیست وظایف
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    کارهات رو مدیریت کن و چیزی رو فراموش نکن
                </p>

            </div>

            <form
                action="add.php"
                method="POST"
                class="mb-7 flex flex-col gap-3 sm:flex-row"
            >

                <input
                    type="text"
                    name="title"
                    placeholder="یک وظیفه جدید بنویس..."
                    autocomplete="off"
                    required
                    class="min-w-0 flex-1 rounded-2xl border border-violet-100 bg-violet-50/40 px-4 py-3.5 text-sm outline-none transition placeholder:text-slate-400 focus:border-violet-300 focus:bg-white focus:ring-4 focus:ring-violet-100"
                >

                <button
                    type="submit"
                    class="group flex items-center justify-center gap-2 rounded-2xl bg-violet-600 px-6 py-3.5 text-sm font-semibold text-white shadow-md shadow-violet-200 transition duration-200 hover:bg-violet-700 hover:shadow-lg hover:shadow-violet-200 active:scale-[0.98]"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-5 w-5 transition-transform duration-200 group-hover:rotate-90"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 4.5v15m7.5-7.5h-15"
                        />
                    </svg>

                    افزودن
                </button>

            </form>

            <div class="space-y-3">

                <?php if ($result->num_rows === 0): ?>

                    <div class="rounded-2xl border border-dashed border-violet-200 bg-violet-50/30 px-5 py-12 text-center">

                        <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-violet-100 text-violet-500">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-6 w-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                />
                            </svg>

                        </div>

                        <p class="text-sm font-medium text-slate-500">
                            هنوز هیچ وظیفه‌ای اضافه نکردی
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            اولین وظیفه‌ات رو از بالا اضافه کن
                        </p>

                    </div>

                <?php else: ?>

                    <?php while ($todo = $result->fetch_assoc()): ?>

                        <div
                            class="todo-item group rounded-2xl border border-violet-100/80 bg-white p-4 transition duration-200 hover:-translate-y-0.5 hover:border-violet-200 hover:shadow-md hover:shadow-violet-100/60"
                            data-id="<?= $todo["id"] ?>"
                        >

                            <div class="flex items-center justify-between gap-4">

                                <span class="todo-title min-w-0 break-words text-sm font-medium text-slate-700">
                                    <?= htmlspecialchars($todo["title"], ENT_QUOTES, "UTF-8") ?>
                                </span>

                                <div class="flex shrink-0 items-center gap-1">

                                    <button
                                        type="button"
                                        class="edit-button rounded-xl p-2.5 text-violet-500 transition hover:bg-violet-50 hover:text-violet-700"
                                        title="ویرایش"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.8"
                                            stroke="currentColor"
                                            class="h-5 w-5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"
                                            />
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M19.5 7.125 16.875 4.5"
                                            />
                                        </svg>
                                    </button>

                                    <button
                                        type="button"
                                        class="delete-button rounded-xl p-2.5 text-pink-500 transition hover:bg-pink-50 hover:text-pink-700"
                                        title="حذف"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke-width="1.8"
                                            stroke="currentColor"
                                            class="h-5 w-5"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12.73.562c.34-.059.682-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                            />
                                        </svg>
                                    </button>

                                </div>

                            </div>

                        </div>

                    <?php endwhile; ?>

                <?php endif; ?>

            </div>

        </section>

    </main>

    <div
        id="toast"
        class="pointer-events-none fixed bottom-6 left-1/2 z-50 flex -translate-x-1/2 translate-y-4 items-center gap-3 rounded-2xl border border-violet-100 bg-white px-5 py-3.5 text-sm font-semibold text-violet-700 opacity-0 shadow-[0_12px_35px_rgba(139,92,246,0.18)] transition-all duration-300"
    >
        <span class="flex h-7 w-7 items-center justify-center rounded-full bg-violet-100 text-violet-600">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
                class="h-4 w-4"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="m4.5 12.75 6 6 9-13.5"
                />
            </svg>

        </span>

        <span id="toast-message"></span>

    </div>

    <div
        id="delete-modal"
        class="pointer-events-none fixed inset-0 z-40 flex items-center justify-center bg-slate-900/30 px-4 opacity-0 backdrop-blur-sm transition-opacity duration-300"
    >

        <div
            id="delete-modal-content"
            class="w-full max-w-sm translate-y-3 scale-95 rounded-3xl bg-white p-6 text-center shadow-2xl transition-all duration-300"
        >

            <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-pink-50 text-pink-500">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-7 w-7"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12.73.562c.34-.059.682-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                    />
                </svg>

            </div>

            <h2 class="text-lg font-bold text-slate-900">
                حذف وظیفه
            </h2>

            <p class="mt-2 text-sm leading-6 text-slate-500">
                مطمئنی می‌خوای این وظیفه رو حذف کنی؟
            </p>

            <div class="mt-6 flex gap-3">

                <button
                    id="cancel-delete"
                    type="button"
                    class="flex-1 rounded-2xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-200"
                >
                    انصراف
                </button>

                <button
                    id="confirm-delete"
                    type="button"
                    class="flex-1 rounded-2xl bg-pink-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-pink-200 transition hover:bg-pink-600"
                >
                    حذف کن
                </button>

            </div>

        </div>

    </div>

    <script src="script.js"></script>

</body>

</html>