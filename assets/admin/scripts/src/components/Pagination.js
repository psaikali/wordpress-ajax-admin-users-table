import React from "react";

class Pagination extends React.Component {
	constructor(props) {
		super(props);
		this.onClickPrevious = this.onClickPrevious.bind(this);
		this.onClickNext = this.onClickNext.bind(this);
	}

	onClickPrevious(event) {
		event.preventDefault();

		if (this.props.pagination.current_page > 1) {
			this.props.onRequestChange({
				paged: this.props.pagination.current_page - 1
			});
		}
	}

	onClickNext(event) {
		event.preventDefault();

		if (
			this.props.pagination.current_page <
			this.props.pagination.total_pages
		) {
			this.props.onRequestChange({
				paged: this.props.pagination.current_page + 1
			});
		}
	}

	render() {
		const pagination = this.props.pagination;

		return (
			<nav className="pagination">
				<ul>
					<li
						className={
							"link previous " +
							(pagination.current_page === 1 ? "disabled" : "")
						}
						onClick={this.onClickPrevious}
					>
						<span>
							<i className="dashicons dashicons-arrow-left-alt" />{" "}
							Previous
						</span>
					</li>
					<li className="text">
						<span>
							Page {this.props.pagination.current_page} of{" "}
							{this.props.pagination.total_pages}
						</span>
					</li>
					<li
						className={
							"link next " +
							(pagination.current_page === pagination.total_pages
								? "disabled"
								: "")
						}
						onClick={this.onClickNext}
					>
						<span>
							Next{" "}
							<i className="dashicons dashicons-arrow-right-alt" />
						</span>
					</li>
				</ul>
			</nav>
		);
	}
}

export default Pagination;
