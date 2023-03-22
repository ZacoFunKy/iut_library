function Book(book) {
  const { title, author, pages } = book;
  return (
    <div className="book">
      <div className="book__title">{title}</div>
      <div className="book__author">{author}</div>
      <div className="book__pages">{pages} pages</div>
    </div>
  );
}

export default Book;