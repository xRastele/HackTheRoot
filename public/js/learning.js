function goToLesson(element) {
    const lessonId = element.getAttribute('data-lesson-id');
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/lesson';

    const hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = 'lesson_id';
    hiddenField.value = lessonId;

    form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();
}